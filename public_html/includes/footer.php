<?php
/**
 * footer.php — Footer + script tags.
 *
 * Variabili attese da config.php:
 *   $lang_code, $allowed_langs
 */
?>
	<footer class="site-footer">
		<p>&copy; <span id="copyrightYear"></span> <a href="https://timeline.salernohub.net" rel="noopener">timeline.salernohub.net</a></p>
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
					navigator.serviceWorker.register('assets/js/service-worker.js')
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
