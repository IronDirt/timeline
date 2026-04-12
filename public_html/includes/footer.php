<?php
/**
 * footer.php — Footer + script tags.
 *
 * Variabili attese da config.php:
 *   $lang_code, $allowed_langs
 */
?>
	<footer class="site-footer">
		<div class="footer-container">
			<div class="footer-item footer-left"></div>
			<div class="footer-item footer-center">
				<span>Copyright &copy; <?php echo date('Y'); ?> <a href="https://salernohub.net" target="_blank" rel="noopener" class="footer-contact">SalernoHUB</a> | <a href="mailto:salernohub@gmail.com" class="footer-contact">Contatti</a></span>
			</div>
			<div class="footer-item footer-right"></div>
		</div>
	</footer>

	</div>

	<script>
		const APP_MODE = <?= json_encode($appMode, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
		const SHARED_TIMELINE_PAYLOAD = <?= json_encode($sharedPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
		const INITIAL_LANG = <?= json_encode($lang_code, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
	</script>
		<script src="lang/it.js"></script>
		<script src="lang/en.js"></script>
		<script src="assets/js/app.js"></script>
<?php
	$other_langs = array_diff($allowed_langs, ['it', 'en']);
	foreach ($other_langs as $ol):
?>
		<script src="lang/<?= htmlspecialchars($ol) ?>.js"></script>
<?php endforeach; ?>
		<!-- PWA: Registrazione service worker -->
		<script>
			if ('serviceWorker' in navigator) {
				window.addEventListener('load', function() {
					navigator.serviceWorker.register('/service-worker.js', { scope: '/' })
						.then(function(registration) {
							// Registrazione riuscita
						}, function(err) {
							// Registrazione fallita
						});
				});
			}
		</script>
</body>
</html>
