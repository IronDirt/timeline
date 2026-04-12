<?php
declare(strict_types=1);

require __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<title><?= htmlspecialchars(t('terms_title') ?? 'Termini e Condizioni') ?> - Timeline SalernoHub</title>
	<meta name="description" content="<?= htmlspecialchars(t('terms_title') ?? 'Termini e Condizioni') ?>">
	<meta name="robots" content="index, follow">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="assets/css/style-landing.css?v=<?= @filemtime('assets/css/style-landing.css') ?: time(); ?>">
	<link rel="manifest" href="manifest.json">
	<style>
		.lp-terms-section {
			padding: 120px 24px 80px;
		}
		.lp-terms-content {
			max-width: 800px;
			margin: 0 auto;
			background: var(--lp-white);
			padding: 40px;
			border-radius: var(--lp-radius-lg);
			box-shadow: var(--lp-shadow);
			border: 1px solid var(--lp-gray-100);
		}
		.lp-terms-content h1 {
			font-size: clamp(2rem, 3vw, 2.5rem);
			font-weight: 800;
			color: var(--lp-gray-900);
			margin-bottom: 8px;
			letter-spacing: -0.02em;
		}
		.lp-terms-content .last-updated {
			display: block;
			color: var(--lp-gray-500);
			font-size: 0.9rem;
			margin-bottom: 40px;
		}
		.lp-terms-content h2 {
			font-size: 1.4rem;
			font-weight: 700;
			color: var(--lp-gray-900);
			margin-top: 32px;
			margin-bottom: 16px;
		}
		.lp-terms-content p {
			font-size: 1.05rem;
			color: var(--lp-gray-700);
			line-height: 1.7;
			margin-bottom: 16px;
		}
		@media (max-width: 768px) {
			.lp-terms-content {
				padding: 24px;
			}
		}
	</style>
</head>
<body class="landing-body">
	<!-- ═══ HEADER / NAV ═══ -->
	<header class="lp-header" id="lpHeader">
		<div class="lp-header-inner">
			<a href="/" class="lp-logo" aria-label="Timeline SalernoHub Home">
				<img src="assets/img/icon-192.png" alt="Timeline SalernoHub" class="lp-logo-img">
				<span class="lp-logo-text">Timeline <strong>SalernoHub</strong></span>
			</a>
			<div class="lp-header-actions">
				<a href="editor.php" class="lp-btn lp-btn-sm lp-btn-primary"><?= htmlspecialchars($lang_code === 'it' ? 'Torna all\'editor' : 'Back to editor') ?></a>
			</div>
		</div>
	</header>

	<main class="lp-terms-section">
		<div class="lp-terms-content">
			<h1><?= htmlspecialchars(t('terms_title')) ?></h1>
			<span class="last-updated"><?= htmlspecialchars(t('terms_last_updated')) ?></span>

			<p><?= htmlspecialchars(t('terms_intro')) ?></p>

			<h2><?= htmlspecialchars(t('terms_h1')) ?></h2>
			<p><?= htmlspecialchars(t('terms_p1')) ?></p>

			<h2><?= htmlspecialchars(t('terms_h2')) ?></h2>
			<p><?= htmlspecialchars(t('terms_p2')) ?></p>

			<h2><?= htmlspecialchars(t('terms_h3')) ?></h2>
			<p><?= htmlspecialchars(t('terms_p3')) ?></p>

			<h2><?= htmlspecialchars(t('terms_h4')) ?></h2>
			<p><?= htmlspecialchars(t('terms_p4')) ?></p>
		</div>
	</main>

	<!-- ═══ FOOTER ═══ -->
	<footer class="lp-footer">
		<div class="lp-footer-bottom">
			<span>Copyright &copy; <?php echo date('Y'); ?> <a href="https://salernohub.net" target="_blank" rel="noopener" class="footer-contact">SalernoHUB</a> | <a href="terms.php" class="footer-contact"><?php echo $lang['terms_and_conditions'] ?? 'Termini e Condizioni'; ?></a> | <a href="mailto:salernohub@gmail.com" class="footer-contact"><?php echo $lang['contacts'] ?? 'Contatti'; ?></a></span>
		</div>
	</footer>

	<script>
	(function() {
		var header = document.getElementById('lpHeader');
		window.addEventListener('scroll', function() {
			header.classList.toggle('lp-header--scrolled', window.scrollY > 40);
		}, { passive: true });
	})();
	</script>
</body>
</html>
