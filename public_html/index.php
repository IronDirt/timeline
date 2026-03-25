<?php
declare(strict_types=1);

// ── Livello 2: Orchestrazione ──────────────────────────────────────
// Carica configurazione lingua e funzioni di supporto
require __DIR__ . '/includes/config.php';

// ── Inizializza directory storage ──────────────────────────────────
$storageDir = timeline_storage_dir();
if (!is_dir($storageDir)) {
	if (!@mkdir($storageDir, 0775, true)) {
		// Non blocchiamo subito, ma l'API darà errore se cercherà di scrivere
	}
}


// ════════════════════════════════════════════════════════════════════
// API: Eliminazione timeline online
// ════════════════════════════════════════════════════════════════════
if (($_GET['api'] ?? '') === 'delete' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
	header('Content-Type: application/json; charset=utf-8');

	try {
		$rawBody = file_get_contents('php://input');
		$payload = json_decode($rawBody ?: '{}', true, 512, JSON_THROW_ON_ERROR);

		$timelineId = isset($payload['timelineId']) && is_string($payload['timelineId'])
			? trim($payload['timelineId'])
			: '';
		$adminToken = isset($payload['adminToken']) && is_string($payload['adminToken'])
			? trim($payload['adminToken'])
			: '';

		if ($timelineId === '' || preg_match('/^[a-f0-9]{12}$/', $timelineId) !== 1) {
			http_response_code(400);
			echo json_encode(['ok' => false, 'message' => 'ID timeline non valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			exit;
		}

		$filePath = $storageDir . '/' . $timelineId . '.json';

		if (!is_file($filePath)) {
			http_response_code(404);
			echo json_encode(['ok' => false, 'message' => 'Timeline non trovata.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			exit;
		}

		$content = file_get_contents($filePath);
		$decoded = json_decode($content ?: '{}', true);

		if (!is_array($decoded) || !isset($decoded['adminToken']) || !hash_equals((string) $decoded['adminToken'], $adminToken)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'message' => 'Token admin non valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			exit;
		}

		unlink($filePath);

		echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		exit;
	} catch (Throwable $error) {
		http_response_code(500);
		echo json_encode([
			'ok' => false,
			'message' => 'Errore durante la cancellazione online: ' . $error->getMessage()
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		exit;
	}

}

// ════════════════════════════════════════════════════════════════════
// API: Salvataggio timeline online
// ════════════════════════════════════════════════════════════════════
if (($_GET['api'] ?? '') === 'save' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
	header('Content-Type: application/json; charset=utf-8');

	try {
		$rawBody = file_get_contents('php://input');
		$payload = json_decode($rawBody ?: '{}', true, 512, JSON_THROW_ON_ERROR);

		$events = $payload['events'] ?? null;
		$title = isset($payload['title']) && is_string($payload['title']) ? trim($payload['title']) : 'Timeline';
		$timelineId = isset($payload['timelineId']) && is_string($payload['timelineId'])
			? trim($payload['timelineId'])
			: '';
		$adminToken = isset($payload['adminToken']) && is_string($payload['adminToken'])
			? trim($payload['adminToken'])
			: '';

		if (!is_array($events)) {
			http_response_code(400);
			echo json_encode([
				'ok' => false,
				'message' => 'Payload non valido: eventi mancanti.'
			], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			exit;
		}

		$existingData = null;
		$isUpdate = false;
		if ($timelineId !== '' && preg_match('/^[a-f0-9]{12}$/', $timelineId) === 1) {
			$filePath = $storageDir . '/' . $timelineId . '.json';
			if (is_file($filePath)) {
				$content = file_get_contents($filePath);
				$decoded = json_decode($content ?: '{}', true);
				if (is_array($decoded) && isset($decoded['adminToken']) && hash_equals((string) $decoded['adminToken'], $adminToken)) {
					$existingData = $decoded;
					$isUpdate = true;
				}
			}
		}

		if (!$isUpdate) {
			do {
				$timelineId = timeline_generate_id(6);
				$filePath = $storageDir . '/' . $timelineId . '.json';
			} while (is_file($filePath));

			$adminToken = timeline_generate_id(16);
			$viewerToken = timeline_generate_id(16);
		} else {
			$filePath = $storageDir . '/' . $timelineId . '.json';
			$adminToken = (string) ($existingData['adminToken'] ?? '');
			$viewerToken = (string) ($existingData['viewerToken'] ?? '');
		}

		$record = [
			'updatedAt' => date(DATE_ATOM),
			'title' => $title !== '' ? $title : 'Timeline',
			'events' => array_values($events),
			'adminToken' => $adminToken,
			'viewerToken' => $viewerToken,
			'version' => 1
		];

		if (!is_dir($storageDir)) {
			throw new Exception("La cartella di storage non esiste e non può essere creata automaticamente. Verifica i permessi della cartella public_html.");
		}
		if (!is_writable($storageDir)) {
			throw new Exception("La cartella di storage '" . basename($storageDir) . "' non è scrivibile dal server. Verifica i permessi (chmod/chown).");
		}

		$jsonRecord = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		if ($jsonRecord === false) {
			throw new Exception("Errore durante la codifica JSON dei dati.");
		}

		if (file_put_contents($filePath, $jsonRecord) === false) {
			throw new Exception("Impossibile scrivere il file sulla VPS. Controlla lo spazio disco o i permessi di scrittura.");
		}

		$urls = timeline_build_share_urls($timelineId, $adminToken, $viewerToken);


		echo json_encode([
			'ok' => true,
			'timelineId' => $timelineId,
			'adminToken' => $adminToken,
			'viewerToken' => $viewerToken,
			'adminUrl' => $urls['adminUrl'],
			'viewerUrl' => $urls['viewerUrl']
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		exit;
	} catch (Throwable $error) {
		http_response_code(500);
		echo json_encode([
			'ok' => false,
			'message' => 'Errore durante il salvataggio online: ' . $error->getMessage()
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		exit;
	}

}

// ════════════════════════════════════════════════════════════════════
// Modalità app (editor / viewer)
// ════════════════════════════════════════════════════════════════════
$appMode = 'editor';
$sharedPayload = null;

$timelineQueryId = isset($_GET['timeline']) && is_string($_GET['timeline']) ? trim($_GET['timeline']) : '';
$adminQueryToken = isset($_GET['admin']) && is_string($_GET['admin']) ? trim($_GET['admin']) : '';
$viewerQueryToken = isset($_GET['view']) && is_string($_GET['view']) ? trim($_GET['view']) : '';

if ($timelineQueryId !== '' && preg_match('/^[a-f0-9]{12}$/', $timelineQueryId) === 1) {
	$filePath = $storageDir . '/' . $timelineQueryId . '.json';
	if (is_file($filePath)) {
		$content = file_get_contents($filePath);
		$decoded = json_decode($content ?: '{}', true);

		if (is_array($decoded)) {
			$storedAdmin = (string) ($decoded['adminToken'] ?? '');
			$storedViewer = (string) ($decoded['viewerToken'] ?? '');
			$canEdit = $adminQueryToken !== '' && $storedAdmin !== '' && hash_equals($storedAdmin, $adminQueryToken);
			$canView = $viewerQueryToken !== '' && $storedViewer !== '' && hash_equals($storedViewer, $viewerQueryToken);

			if ($canEdit || $canView) {
				$appMode = $canView && !$canEdit ? 'viewer' : 'editor';
				$urls = timeline_build_share_urls($timelineQueryId, $storedAdmin, $storedViewer);
				$sharedPayload = [
					'timelineId' => $timelineQueryId,
					'adminToken' => $canEdit ? $storedAdmin : null,
					'viewerToken' => $canEdit ? $storedViewer : null,
					'adminUrl' => $canEdit ? $urls['adminUrl'] : '',
					'viewerUrl' => $urls['viewerUrl'],
					'title' => isset($decoded['title']) && is_string($decoded['title']) ? $decoded['title'] : 'Timeline',
					'events' => isset($decoded['events']) && is_array($decoded['events']) ? $decoded['events'] : []
				];
			}
		}
	}
}

// ════════════════════════════════════════════════════════════════════
// Rendering: include componenti modulari
// ════════════════════════════════════════════════════════════════════
include __DIR__ . '/includes/head.php';
?>
<body>
	<div class="lang-menu-wrap">
		<button type="button" id="langToggleBtn" class="lang-toggle-btn" aria-label="<?= htmlspecialchars(t('langToggleTitle')) ?>" title="<?= htmlspecialchars(t('langToggleTitle')) ?>"><?= htmlspecialchars(t('langToggleLabel')) ?></button>
		<div id="langMenu" class="lang-menu hidden">
<?php
	$lang_labels = [
		'it' => 'Italiano', 'en' => 'English', 'es' => 'Español',
		'de' => 'Deutsch',  'fr' => 'Français', 'pt' => 'Português',
		'ru' => 'Русский',  'tr' => 'Türkçe',   'ja' => '日本語',
		'zh' => '中文',
	];
	foreach ($allowed_langs as $al):
?>
			<button type="button" class="lang-menu-btn" data-lang="<?= $al ?>"><?= $lang_labels[$al] ?? strtoupper($al) ?></button>
<?php endforeach; ?>
		</div>
	</div>
	<div class="container">
		<div class="top-content">
			<h1 data-i18n="appTitle"><?= htmlspecialchars(t('appTitle')) ?></h1>
			<div class="fab-stack top-actions">
				<button type="button" class="fab-add" id="openFormBtn" aria-label="<?= htmlspecialchars(t('addEventLabel')) ?>">
					<svg class="icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
				</button>
				<div class="backup-wrap">
					<button type="button" class="fab-backup" id="backupMenuBtn" aria-label="Backup" title="Backup">
						<svg class="backup-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
							<path d="M12 13v8M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242M8 17l4 4 4-4"></path>
						</svg>
					</button>
					<div class="backup-menu hidden" id="backupMenu" role="menu" aria-label="<?= htmlspecialchars(t('backupMenuAriaLabel')) ?>">
						<div class="online-save-panel" id="onlineSavePanel">
							<div class="online-save-field">
								<label data-i18n="adminLinkLabel" for="adminLinkInput"><?= htmlspecialchars(t('adminLinkLabel')) ?></label>
								<div class="online-save-input-row">
									<input id="adminLinkInput" type="text" readonly placeholder="<?= htmlspecialchars(t('adminLinkPlaceholder')) ?>">
									<button type="button" class="secondary copy-link-btn" id="copyAdminLinkBtn" aria-label="<?= htmlspecialchars(t('copyAdminLinkLabel')) ?>" title="<?= htmlspecialchars(t('copyAdminLinkLabel')) ?>">
										<svg class="icon" viewBox="0 0 24 24">
											<rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
											<path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
										</svg>
									</button>
								</div>
							</div>
							<div class="online-save-field">
								<label data-i18n="viewerLinkLabel" for="viewerLinkInput"><?= htmlspecialchars(t('viewerLinkLabel')) ?></label>
								<div class="online-save-input-row">
									<input id="viewerLinkInput" type="text" readonly placeholder="<?= htmlspecialchars(t('viewerLinkPlaceholder')) ?>">
									<button type="button" class="secondary copy-link-btn" id="copyViewerLinkBtn" aria-label="<?= htmlspecialchars(t('copyViewerLinkLabel')) ?>" title="<?= htmlspecialchars(t('copyViewerLinkLabel')) ?>">
										<svg class="icon" viewBox="0 0 24 24">
											<rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
											<path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
										</svg>
									</button>
								</div>
							</div>
							<div class="backup-actions-row">
								<button type="button" class="secondary" id="downloadBtn" role="menuitem">
									<svg class="icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5l5 5 5-5m-5 5V3"></path></svg>
									<span data-i18n="downloadBtnText"><?= htmlspecialchars(t('downloadBtnText')) ?></span>
								</button>
								<button type="button" class="secondary" id="uploadBtn" role="menuitem">
									<svg class="icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5m5-5v12"></path></svg>
									<span data-i18n="importBtnText"><?= htmlspecialchars(t('importBtnText')) ?></span>
								</button>
								<button type="button" class="primary" id="saveOnlineBtn" role="menuitem">
									<svg class="icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
									<span data-i18n="saveBtnText"><?= htmlspecialchars(t('saveBtnText')) ?></span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<button type="button" class="fab-fullscreen" id="fullscreenBtn" aria-label="<?= htmlspecialchars(t('fullscreenEnterTitle')) ?>" title="<?= htmlspecialchars(t('fullscreenEnterTitle')) ?>">
					<svg class="fullscreen-icon" id="fullscreenEnterIcon" viewBox="0 0 24 24">
						<path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
					</svg>
					<svg class="fullscreen-icon hidden" id="fullscreenExitIcon" viewBox="0 0 24 24">
						<path d="M4 14h6m0 0v6m0-6L3 21m17-7h-6m0 0v6m0-6l7 7M4 10h6m0 0V4m0 6L3 3m17 7h-6m0 0V4m0 6l7-7"></path>
					</svg>
				</button>
				<button type="button" class="fab-theme" id="themeToggleBtn" aria-label="<?= htmlspecialchars(t('themeTitleDark')) ?>" title="<?= htmlspecialchars(t('themeTitleDark')) ?>">
					<svg class="theme-icon theme-icon-moon" id="themeMoonIcon" viewBox="0 0 24 24">
						<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
					</svg>
					<svg class="theme-icon theme-icon-sun hidden" id="themeSunIcon" viewBox="0 0 24 24">
						<circle cx="12" cy="12" r="5"></circle>
						<path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M17.66 6.34l1.42-1.42"></path>
					</svg>
				</button>
				<button type="button" class="muted timeline-reset-btn fab-reset hidden" id="resetTimelineBtn" aria-label="<?= htmlspecialchars(t('resetTimelineLabel')) ?>" title="<?= htmlspecialchars(t('resetTimelineTitle')) ?>">
					<svg class="timeline-reset-icon" viewBox="0 0 24 24">
						<path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m-6 5v6m4-6v6"></path>
					</svg>
				</button>
				<input id="uploadInput" class="hidden" type="file" accept="application/json">
			</div>
		</div>

		<section class="card timeline-section">
			<div class="timeline-topbar">
				<div class="timeline-header">
					<h2 id="timelineTitle">Timeline</h2>
					<button type="button" class="muted timeline-title-edit" id="editTimelineTitleBtn" aria-label="<?= htmlspecialchars(t('editTitleLabel')) ?>" title="<?= htmlspecialchars(t('editTitleTitle')) ?>">
						<svg class="icon" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
					</button>
				</div>
				<div class="timeline-right-controls">
					<div class="viewer-actions hidden" id="viewerActions" aria-label="<?= htmlspecialchars(t('viewerActionsLabel')) ?>">
						<button type="button" class="primary viewer-action-btn" id="viewerCreateBtn">
							<svg class="icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
							<span data-i18n="viewerCreateBtnText"><?= htmlspecialchars(t('viewerCreateBtnText')) ?></span>
						</button>
						<button type="button" class="secondary viewer-action-btn viewer-icon-btn" id="viewerDownloadBtn" aria-label="<?= htmlspecialchars(t('viewerDownloadLabel')) ?>" title="<?= htmlspecialchars(t('viewerDownloadLabel')) ?>">
							<svg class="viewer-action-icon" viewBox="0 0 24 24">
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5l5 5 5-5m-5 5V3"></path>
							</svg>
						</button>
						<button type="button" class="secondary viewer-action-btn viewer-icon-btn" id="viewerFullscreenBtn" aria-label="<?= htmlspecialchars(t('fullscreenEnterTitle')) ?>" title="<?= htmlspecialchars(t('fullscreenEnterTitle')) ?>">
							<svg class="viewer-action-icon" id="viewerFullscreenEnterIcon" viewBox="0 0 24 24">
								<path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
							</svg>
							<svg class="viewer-action-icon hidden" id="viewerFullscreenExitIcon" viewBox="0 0 24 24">
								<path d="M4 14h6m0 0v6m0-6L3 21m17-7h-6m0 0v6m0-6l7 7M4 10h6m0 0V4m0 6L3 3m17 7h-6m0 0V4m0 6l7-7"></path>
							</svg>
						</button>
					</div>
						<div class="timeline-zoom-controls" data-i18n-aria-label="zoomControlsLabel" aria-label="<?= htmlspecialchars(t('zoomControlsLabel')) ?>">
						<button type="button" class="muted timeline-zoom-btn" id="zoomOutBtn" aria-label="<?= htmlspecialchars(t('zoomOutLabel')) ?>" title="<?= htmlspecialchars(t('zoomOutTitle')) ?>">
							<svg class="icon" viewBox="0 0 24 24"><path d="M5 12h14"></path></svg>
						</button>
						<button type="button" class="muted timeline-zoom-btn" id="zoomInBtn" aria-label="<?= htmlspecialchars(t('zoomInLabel')) ?>" title="<?= htmlspecialchars(t('zoomInTitle')) ?>">
							<svg class="icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
						</button>
					</div>
				</div>
			</div>
			<div id="timeline" class="timeline"></div>
		</section>

<?php include __DIR__ . '/includes/modals.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
