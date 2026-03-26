<?php
/**
 * modals.php — Modali evento e local reset.
 *
 * Testi statici letti da $lang[] (PHP server-side).
 * Attributi data-i18n mantenuti per compatibilità JS dinamica.
 */
?>
	<div class="modal hidden" id="localResetModal" role="dialog" aria-modal="true" aria-labelledby="localResetTitle">
		<div class="modal-backdrop" id="localResetBackdrop"></div>
		<section class="modal-card local-reset-card">
			<div class="modal-header">
					<h2 id="localResetTitle"><?= htmlspecialchars(t('localResetTitleText')) ?></h2>
				<button type="button" class="muted close-btn" id="closeLocalResetBtn" aria-label="<?= htmlspecialchars(t('closeLabel')) ?>">
					<svg class="icon" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
				</button>
			</div>
			<p class="local-reset-text" data-i18n="localResetText1"><?= htmlspecialchars(t('localResetText1')) ?></p>
			<p class="local-reset-text" data-i18n="localResetText2"><?= htmlspecialchars(t('localResetText2')) ?></p>
			<p class="local-reset-text" data-i18n="localResetText3"><?= htmlspecialchars(t('localResetText3')) ?></p>
			<div class="local-reset-actions">
				<button type="button" class="secondary" id="localResetDownloadBtn">
					<svg class="icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5l5 5 5-5m-5 5V3"></path></svg>
					<span data-i18n="localResetDownloadText"><?= htmlspecialchars(t('localResetDownloadText')) ?></span>
				</button>
				<button type="button" class="secondary" id="localResetSaveOnlineBtn">
					<svg class="icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
					<span data-i18n="localResetSaveOnlineText"><?= htmlspecialchars(t('localResetSaveOnlineText')) ?></span>
				</button>
				<button type="button" class="danger" id="localResetConfirmBtn">
					<svg class="icon" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
					<span data-i18n="localResetConfirmText"><?= htmlspecialchars(t('localResetConfirmText')) ?></span>
				</button>
				<button type="button" class="danger" id="localResetDeleteOnlineBtn">
					<svg class="icon" viewBox="0 0 24 24"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m-6 5v6m4-6v6"></path></svg>
					<span data-i18n="localResetDeleteOnlineText"><?= htmlspecialchars(t('localResetDeleteOnlineText')) ?></span>
				</button>
			</div>
			<div class="local-reset-online-panel online-save-field hidden" id="localResetAdminLinkWrap">
				<label data-i18n="localResetAdminLinkLabel" for="localResetAdminLinkInput"><?= htmlspecialchars(t('localResetAdminLinkLabel')) ?></label>
				<div class="online-save-input-row">
					<input type="text" id="localResetAdminLinkInput" readonly placeholder="<?= htmlspecialchars(t('localResetAdminLinkPlaceholder')) ?>">
					<button type="button" class="muted copy-link-btn" id="localResetCopyAdminLinkBtn" aria-label="<?= htmlspecialchars(t('copyAdminLinkLabel')) ?>" title="<?= htmlspecialchars(t('copyAdminLinkLabel')) ?>">
						<svg class="icon" viewBox="0 0 24 24">
							<rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
							<path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
						</svg>
					</button>
				</div>
			</div>
		</section>
	</div>

	<div class="mobile-viewer-menu-wrap hidden" id="mobileViewerMenuWrap" aria-label="<?= htmlspecialchars(t('mobileViewerActionsLabel')) ?>">
		<button type="button" class="primary mobile-viewer-action-btn mobile-viewer-create-btn hidden" id="mobileViewerCreateBtn">
			<svg class="icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
			<span data-i18n="viewerCreateBtnText"><?= htmlspecialchars(t('viewerCreateBtnText')) ?></span>
		</button>
		<div class="mobile-viewer-menu hidden" id="mobileViewerMenu">
			<button type="button" class="muted mobile-viewer-icon-btn" id="mobileViewerZoomInBtn" aria-label="<?= htmlspecialchars(t('zoomInLabel')) ?>" title="<?= htmlspecialchars(t('zoomInTitle')) ?>">
				<svg class="icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
			</button>
			<button type="button" class="muted mobile-viewer-icon-btn" id="mobileViewerZoomOutBtn" aria-label="<?= htmlspecialchars(t('zoomOutLabel')) ?>" title="<?= htmlspecialchars(t('zoomOutTitle')) ?>">
				<svg class="icon" viewBox="0 0 24 24"><path d="M5 12h14"></path></svg>
			</button>
			<button type="button" class="secondary mobile-viewer-icon-btn" id="mobileViewerThemeBtn" aria-label="<?= htmlspecialchars(t('themeTitleDark')) ?>" title="<?= htmlspecialchars(t('themeTitleDark')) ?>">
				<svg class="viewer-action-icon" id="mobileViewerThemeMoonIcon" viewBox="0 0 24 24">
					<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
				</svg>
				<svg class="viewer-action-icon hidden" id="mobileViewerThemeSunIcon" viewBox="0 0 24 24">
					<circle cx="12" cy="12" r="5"></circle>
					<path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M17.66 6.34l1.42-1.42"></path>
				</svg>
			</button>
			<button type="button" class="secondary mobile-viewer-icon-btn" id="mobileViewerFullscreenBtn" aria-label="<?= htmlspecialchars(t('fullscreenEnterTitle')) ?>" title="<?= htmlspecialchars(t('fullscreenEnterTitle')) ?>">
				<svg class="viewer-action-icon" id="mobileViewerFullscreenEnterIcon" viewBox="0 0 24 24">
					<path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
				</svg>
				<svg class="viewer-action-icon hidden" id="mobileViewerFullscreenExitIcon" viewBox="0 0 24 24">
					<path d="M4 14h6m0 0v6m0-6L3 21m17-7h-6m0 0v6m0-6l7 7M4 10h6m0 0V4m0 6L3 3m17 7h-6m0 0V4m0 6l7-7"></path>
				</svg>
			</button>
			<button type="button" class="secondary mobile-viewer-icon-btn" id="mobileViewerDownloadBtn" aria-label="<?= htmlspecialchars(t('viewerDownloadLabel')) ?>" title="<?= htmlspecialchars(t('viewerDownloadLabel')) ?>">
				<svg class="viewer-action-icon" viewBox="0 0 24 24">
					<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5l5 5 5-5m-5 5V3"></path>
				</svg>
			</button>
		</div>
		<button type="button" class="mobile-viewer-menu-btn" id="mobileViewerMenuBtn" aria-label="<?= htmlspecialchars(t('mobileViewerMenuOpenLabel')) ?>" title="<?= htmlspecialchars(t('mobileViewerMenuTitle')) ?>">
			<svg class="backup-icon" id="mobileViewerMenuOpenIcon" viewBox="0 0 24 24">
				<path d="M3 12h18M3 6h18M3 18h18"></path>
			</svg>
			<svg class="backup-icon hidden" id="mobileViewerMenuCloseIcon" viewBox="0 0 24 24">
				<path d="M18 6L6 18M6 6l12 12"></path>
			</svg>
		</button>
	</div>

	<div class="modal hidden" id="eventModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
		<div class="modal-backdrop" id="modalBackdrop"></div>
		<section class="modal-card">
			<div class="modal-header">
				<h2 id="modalTitle"><?= htmlspecialchars(t('modalNewEventTitle')) ?></h2>
				<button type="button" class="muted close-btn" id="closeModalBtn" aria-label="<?= htmlspecialchars(t('closeLabel')) ?>">
					<svg class="icon" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
				</button>
			</div>

			<form id="eventForm">
				<input type="hidden" id="editIndex" value="-1">

				<div class="modal-body-grid">
					<!-- Left Column: Fields -->
					<div class="modal-column">
						<div class="field-section custom-year-toggle-row">
							<div class="ios-switch-row">
								<label class="ios-switch">
									<input id="eventUseCustomYear" type="checkbox">
									<span class="slider round"></span>
								</label>
								<label for="eventUseCustomYear" class="ios-switch-label" style="font-size: 1.05rem;" data-i18n="useCustomYearText"><?= htmlspecialchars(t('useCustomYearText')) ?></label>
							</div>
							<input id="eventCustomYear" style="margin-top:10px;" class="year-input smooth-collapse is-closed" type="number" step="1" placeholder="<?= htmlspecialchars(t('customYearPlaceholder')) ?>">
						</div>

						<div class="field-section smooth-collapse" id="standardDateBlock">
							<label data-i18n="dateLabel" for="eventDate"><?= htmlspecialchars(t('dateLabel')) ?></label>
							<input id="eventDate" type="date" required>
							
							<div class="date-visibility-options">
								<div class="ios-switch-row">
									<label class="ios-switch">
										<input id="eventShowDay" type="checkbox" checked>
										<span class="slider round"></span>
									</label>
									<label for="eventShowDay" class="ios-switch-label" data-i18n="showDayText"><?= htmlspecialchars(t('showDayText')) ?></label>
								</div>
								<div class="ios-switch-row">
									<label class="ios-switch">
										<input id="eventShowMonth" type="checkbox" checked>
										<span class="slider round"></span>
									</label>
									<label for="eventShowMonth" class="ios-switch-label" data-i18n="showMonthText"><?= htmlspecialchars(t('showMonthText')) ?></label>
								</div>
							</div>
						</div>

						<div class="field-section">
							<label data-i18n="eraTagLabel"><?= htmlspecialchars(t('eraTagLabel')) ?></label>
							<div class="date-visibility-options">
								<div class="ios-switch-row">
									<label class="ios-switch">
										<input id="eraTagChristian" type="checkbox" value="christian">
										<span class="slider round"></span>
									</label>
									<label for="eraTagChristian" class="ios-switch-label" data-i18n="eraChristianOption"><?= htmlspecialchars(t('eraChristianOption')) ?></label>
								</div>
								<div class="ios-switch-row">
									<label class="ios-switch">
										<input id="eraTagCommon" type="checkbox" value="common-era">
										<span class="slider round"></span>
									</label>
									<label for="eraTagCommon" class="ios-switch-label" data-i18n="eraCommonEraOption"><?= htmlspecialchars(t('eraCommonEraOption')) ?></label>
								</div>
							</div>
						</div>

						<div class="field-section">
							<label data-i18n="titleLabel" for="eventTitle"><?= htmlspecialchars(t('titleLabel')) ?></label>
							<input id="eventTitle" type="text" placeholder="<?= htmlspecialchars(t('titlePlaceholder')) ?>" required>
						</div>
					</div>

					<!-- Right Column: Text & Image -->
					<div class="modal-column">
						<div class="field-section flex-fill">
							<label data-i18n="textLabel" for="eventText"><?= htmlspecialchars(t('textLabel')) ?></label>
							<textarea id="eventText" class="tall-textarea" placeholder="<?= htmlspecialchars(t('textPlaceholder')) ?>"></textarea>
						</div>

						<div class="field-section">
							<label data-i18n="imageLabel" for="eventImage"><?= htmlspecialchars(t('imageLabel')) ?></label>
							<div id="eventImageDropZone" class="drop-zone">
								<div class="drop-zone-content" id="dropZoneContent">
									<svg class="icon drop-zone-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5l5 5 5-5m-5 5V3"></path></svg>
									<span data-i18n="chooseImageText" class="drop-zone-text"><?= htmlspecialchars(t('chooseImageText')) ?></span>
									<span id="eventImageName" class="image-picker-name hidden"><?= htmlspecialchars(t('noFileSelected')) ?></span>
									<span class="drop-zone-hint">Drag & drop o fai clic</span>
								</div>
								<div id="eventImagePreviewWrap" class="image-preview-wrap hidden">
									<img id="eventImagePreview" class="image-preview" src="" alt="<?= htmlspecialchars(t('imagePreviewAlt')) ?>">
									<button type="button" id="removeEventImageBtn" class="danger icon-only image-remove-btn" title="<?= htmlspecialchars(t('removeImageText')) ?>" aria-label="<?= htmlspecialchars(t('removeImageText')) ?>">
										<svg class="icon" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
									</button>
								</div>
								<input id="eventImage" class="hidden-file-input" type="file" accept="image/*">
							</div>
						</div>
					</div>
				</div>

				<div class="form-actions modal-footer-actions">
					<button type="submit" class="primary" id="saveEventBtn">
						<svg class="icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
						<span id="saveEventBtnText" data-i18n="addEventText"><?= htmlspecialchars(t('addEventText')) ?></span>
					</button>
				</div>
			</form>
		</section>
	</div>
<div class="modal hidden" id="deleteConfirmModal" role="dialog" aria-modal="true" aria-labelledby="deleteConfirmTitle">
		<div class="modal-backdrop" id="deleteConfirmBackdrop"></div>
		<section class="modal-card delete-confirm-card">
			<div class="modal-header">
				<h2 id="deleteConfirmTitle" data-i18n="deleteConfirmTitle"><?= htmlspecialchars(t('deleteConfirmTitle')) ?></h2>
				<button type="button" class="muted close-btn" id="closeDeleteConfirmBtn" aria-label="<?= htmlspecialchars(t('closeLabel')) ?>">
					<svg class="icon" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
				</button>
			</div>
			<p class="local-reset-text" data-i18n="deleteConfirmText"><?= htmlspecialchars(t('deleteConfirmText')) ?></p>
			<div class="form-actions delete-confirm-actions">
				<button type="button" class="secondary" id="cancelDeleteBtn">
					<span data-i18n="deleteConfirmCancel"><?= htmlspecialchars(t('deleteConfirmCancel')) ?></span>
				</button>
				<button type="button" class="danger" id="confirmDeleteBtn">
					<svg class="icon" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
					<span data-i18n="deleteConfirmBtn"><?= htmlspecialchars(t('deleteConfirmBtn')) ?></span>
				</button>
			</div>
		</section>
	</div>
