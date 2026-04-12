<?php
declare(strict_types=1);

require __DIR__ . '/includes/config.php';

// ── Redirect: se arrivano parametri timeline/api, manda a editor.php ──
$hasTimeline = isset($_GET['timeline']) && $_GET['timeline'] !== '';
$hasApi      = isset($_GET['api']) && $_GET['api'] !== '';
$hasNew      = isset($_GET['new']);

if ($hasTimeline || $hasApi || $hasNew) {
	$qs = $_SERVER['QUERY_STRING'] ?? '';
	header('Location: editor.php' . ($qs !== '' ? '?' . $qs : ''), true, 302);
	exit;
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<title><?= htmlspecialchars(t('page_title')) ?></title>
	<meta name="description" content="<?= htmlspecialchars(t('page_description')) ?>">
	<meta name="keywords" content="<?= htmlspecialchars($lang['page_keywords'] ?? '') ?>">
	<meta name="author" content="SalernoHub">
	<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
	<link rel="canonical" href="https://timeline.salernohub.net/<?= $lang_code !== 'it' ? '?lang=' . $lang_code : '' ?>">
<?php foreach ($allowed_langs as $al): ?>
	<link rel="alternate" href="https://timeline.salernohub.net/<?= $al !== 'it' ? '?lang=' . $al : '' ?>" hreflang="<?= htmlspecialchars($al) ?>">
<?php endforeach; ?>
	<link rel="alternate" href="https://timeline.salernohub.net/" hreflang="x-default">
	<meta property="og:type" content="website">
	<meta property="og:locale" content="<?= htmlspecialchars($current_locale) ?>">
	<meta property="og:site_name" content="Timeline SalernoHub">
	<meta property="og:title" content="<?= htmlspecialchars(t('og_title')) ?>">
	<meta property="og:description" content="<?= htmlspecialchars(t('og_description')) ?>">
	<meta property="og:url" content="https://timeline.salernohub.net/<?= $lang_code !== 'it' ? '?lang=' . $lang_code : '' ?>">
	<meta property="og:image" content="https://timeline.salernohub.net/assets/img/og-image.svg">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?= htmlspecialchars(t('og_title')) ?>">
	<meta name="twitter:description" content="<?= htmlspecialchars(t('twitter_description')) ?>">
	<meta name="application-name" content="Timeline SalernoHub">
	<meta name="theme-color" content="#ffffff">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<script defer src="https://analytics.salernohub.net/script.js" data-website-id="1f14c9f6-0bbd-43e5-b917-115428e581ce"></script>
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "WebSite",
		"name": "Timeline SalernoHub",
		"url": "https://timeline.salernohub.net/",
		"inLanguage": "<?= htmlspecialchars($current_locale) ?>",
		"description": <?= json_encode(t('schema_description'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
	}
	</script>
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "SoftwareApplication",
		"name": "Timeline SalernoHub",
		"applicationCategory": "EducationalApplication",
		"operatingSystem": "Web",
		"url": "https://timeline.salernohub.net/",
		"offers": { "@type": "Offer", "price": "0", "priceCurrency": "EUR" },
		"description": <?= json_encode(t('schema_app_description'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
	}
	</script>
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "FAQPage",
		"mainEntity": [
			{
				"@type": "Question",
				"name": <?= json_encode(t('faq_q1'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
				"acceptedAnswer": { "@type": "Answer", "text": <?= json_encode(t('faq_a1'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?> }
			},
			{
				"@type": "Question",
				"name": <?= json_encode(t('faq_q2'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
				"acceptedAnswer": { "@type": "Answer", "text": <?= json_encode(t('faq_a2'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?> }
			},
			{
				"@type": "Question",
				"name": <?= json_encode(t('faq_q3'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
				"acceptedAnswer": { "@type": "Answer", "text": <?= json_encode(t('faq_a3'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?> }
			}
		]
	}
	</script>
	<link rel="stylesheet" href="assets/css/style-landing.css?v=<?= @filemtime('assets/css/style-landing.css') ?: time(); ?>">
	<link rel="manifest" href="manifest.json">
</head>
<body class="landing-body">

	<!-- ═══ HEADER / NAV ═══ -->
	<header class="lp-header" id="lpHeader">
		<div class="lp-header-inner">
			<a href="/" class="lp-logo" aria-label="Timeline SalernoHub Home">
				<img src="assets/img/icon-192.png" alt="Timeline SalernoHub" class="lp-logo-img">
				<span class="lp-logo-text">Timeline <strong>SalernoHub</strong></span>
			</a>
			<nav class="lp-nav" id="lpNav" aria-label="Navigazione principale">
				<a href="#come-funziona">Come funziona</a>
				<a href="#funzionalita">Funzionalità</a>
				<a href="#esempi">Esempi</a>
				<a href="#faq">FAQ</a>
			</nav>
			<div class="lp-header-actions">
				<a href="editor.php" class="lp-btn lp-btn-sm lp-btn-primary">Inizia gratis</a>
				<button type="button" class="lp-mobile-menu-btn" id="lpMobileMenuBtn" aria-label="Apri menu" aria-expanded="false">
					<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
				</button>
			</div>
		</div>
	</header>

	<!-- ═══ HERO ═══ -->
	<section class="lp-hero">
		<div class="lp-hero-bg" aria-hidden="true">
			<div class="lp-hero-orb lp-hero-orb--1"></div>
			<div class="lp-hero-orb lp-hero-orb--2"></div>
			<div class="lp-hero-orb lp-hero-orb--3"></div>
		</div>
		<div class="lp-hero-inner">
			<div class="lp-hero-content" data-reveal>
				<span class="lp-badge">100% Gratuito &middot; Nessuna registrazione</span>
				<h1 class="lp-hero-title">Dai forma al tempo con timeline eleganti e professionali</h1>
				<p class="lp-hero-sub"><?= htmlspecialchars(t('landingSubtitle')) ?></p>
				<div class="lp-hero-cta">
					<a href="editor.php" class="lp-btn lp-btn-lg lp-btn-primary">
						Crea la tua timeline
						<svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
					</a>
					<a href="#come-funziona" class="lp-btn lp-btn-lg lp-btn-ghost">Scopri come funziona</a>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ COME FUNZIONA ═══ -->
	<section class="lp-section" id="come-funziona">
		<div class="lp-section-inner">
			<div class="lp-section-header" data-reveal>
				<span class="lp-section-label">Semplicissimo</span>
				<h2>Come funziona</h2>
				<p>Tre passaggi per creare, condividere e presentare la tua linea temporale.</p>
			</div>
			<div class="lp-steps">
				<article class="lp-step" data-reveal>
					<div class="lp-step-num">1</div>
					<div class="lp-step-icon">
						<svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
					</div>
					<h3>Inserisci eventi</h3>
					<p>Aggiungi date, titoli, descrizioni e immagini per ogni tappa della tua storia.</p>
				</article>
				<article class="lp-step" data-reveal data-reveal-delay="120">
					<div class="lp-step-num">2</div>
					<div class="lp-step-icon">
						<svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
					</div>
					<h3>Salva e condividi</h3>
					<p>Ottieni un link admin per modificare e un link pubblico per condividere senza rischi.</p>
				</article>
				<article class="lp-step" data-reveal data-reveal-delay="240">
					<div class="lp-step-num">3</div>
					<div class="lp-step-icon">
						<svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
					</div>
					<h3>Presenta con stile</h3>
					<p>Modalità fullscreen, zoom e tema scuro per lezioni, riunioni e storytelling.</p>
				</article>
			</div>
		</div>
	</section>

	<!-- ═══ FUNZIONALITÀ ═══ -->
	<section class="lp-section lp-section--alt" id="funzionalita">
		<div class="lp-section-inner">
			<div class="lp-section-header" data-reveal>
				<span class="lp-section-label">Tutto incluso</span>
				<h2>Funzionalità principali</h2>
				<p>Strumenti potenti senza complessità — tutto nel tuo browser.</p>
			</div>
			<div class="lp-features-grid">
				<div class="lp-feature" data-reveal>
					<div class="lp-feature-icon">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
					</div>
					<h3>Editor intuitivo</h3>
					<p>Aggiunta rapida di eventi con data, titolo, descrizione e immagini. Drag &amp; drop incluso.</p>
				</div>
				<div class="lp-feature" data-reveal data-reveal-delay="80">
					<div class="lp-feature-icon">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
					</div>
					<h3>Tema chiaro e scuro</h3>
					<p>Switch automatico con preferenze di sistema o toggle manuale.</p>
				</div>
				<div class="lp-feature" data-reveal data-reveal-delay="160">
					<div class="lp-feature-icon">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
					</div>
					<h3>Condivisione sicura</h3>
					<p>Link admin con token privato e link viewer per la visualizzazione pubblica.</p>
				</div>
				<div class="lp-feature" data-reveal data-reveal-delay="240">
					<div class="lp-feature-icon">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
					</div>
					<h3>Fullscreen &amp; Zoom</h3>
					<p>Presentazioni a schermo intero con controlli di zoom per ogni dettaglio.</p>
				</div>
				<div class="lp-feature" data-reveal data-reveal-delay="320">
					<div class="lp-feature-icon">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
					</div>
					<h3>Import/Export JSON</h3>
					<p>Scarica i tuoi dati, importali su un altro dispositivo, nessun lock-in.</p>
				</div>
				<div class="lp-feature" data-reveal data-reveal-delay="400">
					<div class="lp-feature-icon">
						<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
					</div>
					<h3>10 lingue supportate</h3>
					<p>Interfaccia multilingua: italiano, inglese, spagnolo, tedesco, francese e altre.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ═══ ESEMPI ═══ -->
	<section class="lp-section" id="esempi">
		<div class="lp-section-inner">
			<div class="lp-section-header" data-reveal>
				<span class="lp-section-label">Casi d'uso</span>
				<h2>Perfetta per ogni occasione</h2>
				<p>Dalla scuola al lavoro, dagli eventi personali ai progetti creativi.</p>
			</div>
			<div class="lp-examples-grid">
				<article class="lp-example" data-reveal>
					<div class="lp-example-icon">
						<svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
							<path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
						</svg>
					</div>
					<h3>Scuola e università</h3>
					<p>Rivoluzioni storiche, cronologie scientifiche, letteratura e programmi didattici.</p>
				</article>
				<article class="lp-example" data-reveal data-reveal-delay="100">
					<div class="lp-example-icon">
						<svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
							<path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
						</svg>
					</div>
					<h3>Lavoro e project management</h3>
					<p>Roadmap di prodotto, milestone di progetto, piani marketing e avanzamento team.</p>
				</article>
				<article class="lp-example" data-reveal data-reveal-delay="200">
					<div class="lp-example-icon">
						<svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/>
							<line x1="9" y1="3" x2="9" y2="18"/>
							<line x1="15" y1="6" x2="15" y2="21"/>
						</svg>
					</div>
					<h3>Viaggi e vita personale</h3>
					<p>Diari di viaggio, anniversari, tappe familiari e percorsi formativi.</p>
				</article>
				<article class="lp-example" data-reveal data-reveal-delay="300">
					<div class="lp-example-icon">
						<svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<path d="M2 22h20 M4 22v-8 M8 22v-8 M12 22v-8 M16 22v-8 M20 22v-8 M2 14h20 M12 3l10 7H2L12 3z"/>
						</svg>
					</div>
					<h3>Storia e religione</h3>
					<p>Linee del tempo religiose, cronologie storiche, eventi epocali e tradizioni.</p>
				</article>
			</div>
		</div>
	</section>

	<!-- ═══ FAQ ═══ -->
	<section class="lp-section lp-section--alt" id="faq">
		<div class="lp-section-inner lp-section-inner--narrow">
			<div class="lp-section-header" data-reveal>
				<span class="lp-section-label">Domande frequenti</span>
				<h2>FAQ</h2>
			</div>
			<div class="lp-faq-list">
				<details class="lp-faq" data-reveal>
					<summary><?= htmlspecialchars(t('faq_q1')) ?></summary>
					<p><?= htmlspecialchars(t('faq_a1')) ?></p>
				</details>
				<details class="lp-faq" data-reveal data-reveal-delay="80">
					<summary><?= htmlspecialchars(t('faq_q2')) ?></summary>
					<p><?= htmlspecialchars(t('faq_a2')) ?></p>
				</details>
				<details class="lp-faq" data-reveal data-reveal-delay="160">
					<summary><?= htmlspecialchars(t('faq_q3')) ?></summary>
					<p><?= htmlspecialchars(t('faq_a3')) ?></p>
				</details>
				<details class="lp-faq" data-reveal data-reveal-delay="240">
					<summary>Devo registrarmi per usare il servizio?</summary>
					<p>No, Timeline SalernoHub è completamente gratuito e non richiede alcuna registrazione. Puoi iniziare subito a creare la tua linea temporale.</p>
				</details>
				<details class="lp-faq" data-reveal data-reveal-delay="320">
					<summary>I miei dati sono al sicuro?</summary>
					<p>I tuoi eventi vengono salvati localmente nel browser. Se scegli di salvare online, i dati sono protetti da token privati e puoi cancellarli in qualsiasi momento.</p>
				</details>
			</div>
		</div>
	</section>

	<!-- ═══ CTA FINALE ═══ -->
	<section class="lp-cta-section">
		<div class="lp-cta-inner" data-reveal>
			<h2>Pronto a raccontare la tua storia?</h2>
			<p>Crea la tua prima timeline in meno di un minuto. Gratuito, senza registrazione.</p>
			<a href="editor.php" class="lp-btn lp-btn-lg lp-btn-white">
				Inizia ora
				<svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
			</a>
		</div>
	</section>

	<!-- ═══ FOOTER ═══ -->
	<footer class="lp-footer">
		<div class="lp-footer-bottom">
			<span>Copyright &copy; <?php echo date('Y'); ?> <a href="https://salernohub.net" target="_blank" rel="noopener" class="footer-contact">SalernoHUB</a> | <a href="terms.php" class="footer-contact"><?php echo $lang['terms_and_conditions'] ?? 'Termini e Condizioni'; ?></a> | <a href="mailto:salernohub@gmail.com" class="footer-contact"><?php echo $lang['contacts'] ?? 'Contatti'; ?></a></span>
		</div>
	</footer>

	<!-- ═══ Script: scroll reveal + mobile menu ═══ -->
	<script>
	(function() {
		/* ── Header scroll ── */
		var header = document.getElementById('lpHeader');
		window.addEventListener('scroll', function() {
			header.classList.toggle('lp-header--scrolled', window.scrollY > 40);
		}, { passive: true });

		/* ── Mobile menu ── */
		var menuBtn = document.getElementById('lpMobileMenuBtn');
		var nav = document.getElementById('lpNav');
		if (menuBtn && nav) {
			menuBtn.addEventListener('click', function() {
				var open = nav.classList.toggle('lp-nav--open');
				menuBtn.setAttribute('aria-expanded', String(open));
			});
			nav.querySelectorAll('a').forEach(function(a) {
				a.addEventListener('click', function() {
					nav.classList.remove('lp-nav--open');
					menuBtn.setAttribute('aria-expanded', 'false');
				});
			});
		}

		/* ── Scroll reveal (IntersectionObserver) ── */
		var reveals = document.querySelectorAll('[data-reveal]');
		if ('IntersectionObserver' in window && reveals.length) {
			var observer = new IntersectionObserver(function(entries) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting) {
						var delay = parseInt(entry.target.dataset.revealDelay || '0', 10);
						setTimeout(function() {
							entry.target.classList.add('revealed');
						}, delay);
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
			reveals.forEach(function(el) { observer.observe(el); });
		} else {
			reveals.forEach(function(el) { el.classList.add('revealed'); });
		}

		/* ── Smooth scroll per anchor ── */
		document.querySelectorAll('a[href^="#"]').forEach(function(a) {
			a.addEventListener('click', function(e) {
				var target = document.querySelector(this.getAttribute('href'));
				if (target) {
					e.preventDefault();
					target.scrollIntoView({ behavior: 'smooth', block: 'start' });
				}
			});
		});
	})();
	</script>
</body>
</html>
