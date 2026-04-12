<?php
/**
 * head.php — Tag <head> completo con SEO i18n dinamico.
 *
 * Variabili attese da config.php:
 *   $lang_code, $lang, $allowed_langs, $current_locale
 */
$isParametric = (isset($_GET['timeline']) && $_GET['timeline'] !== '') || (isset($_GET['api']) && $_GET['api'] !== '') || isset($_GET['new']);
$robotsContent = $isParametric ? "noindex, nofollow" : "index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1";
$bingbotContent = $isParametric ? "noindex, nofollow" : "index, follow";
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
	<meta name="robots" content="<?= $robotsContent ?>">
	<meta name="googlebot" content="<?= $robotsContent ?>">
	<meta name="bingbot" content="<?= $bingbotContent ?>">
	<link rel="canonical" href="https://timeline.salernohub.net/<?= $lang_code !== 'it' ? '?lang=' . $lang_code : '' ?>">
<?php foreach ($allowed_langs as $al): ?>
	<link rel="alternate" href="https://timeline.salernohub.net/<?= $al !== 'it' ? '?lang=' . $al : '' ?>" hreflang="<?= htmlspecialchars($al) ?>">
<?php endforeach; ?>
	<link rel="alternate" href="https://timeline.salernohub.net/" hreflang="x-default">
	<meta property="og:type" content="website">
	<meta property="og:locale" content="<?= htmlspecialchars($current_locale) ?>">
<?php foreach ($allowed_langs as $al): if ($al !== $lang_code):
	$localesMap = ['it'=>'it_IT','en'=>'en_US','es'=>'es_ES','de'=>'de_DE','fr'=>'fr_FR','pt'=>'pt_PT','ru'=>'ru_RU','tr'=>'tr_TR','ja'=>'ja_JP','zh'=>'zh_CN'];
?>
	<meta property="og:locale:alternate" content="<?= htmlspecialchars($localesMap[$al] ?? $al) ?>">
<?php endif; endforeach; ?>
	<meta property="og:site_name" content="Timeline SalernoHub">
	<meta property="og:title" content="<?= htmlspecialchars(t('og_title')) ?>">
	<meta property="og:description" content="<?= htmlspecialchars(t('og_description')) ?>">
	<meta property="og:url" content="https://timeline.salernohub.net/<?= $lang_code !== 'it' ? '?lang=' . $lang_code : '' ?>">
	<meta property="og:image" content="https://timeline.salernohub.net/assets/img/og-image.svg">
	<meta property="og:image:secure_url" content="https://timeline.salernohub.net/assets/img/og-image.svg">
	<meta property="og:image:type" content="image/svg+xml">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:image:alt" content="<?= htmlspecialchars(t('og_title')) ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?= htmlspecialchars(t('og_title')) ?>">
	<meta name="twitter:description" content="<?= htmlspecialchars(t('twitter_description')) ?>">
	<meta name="twitter:image" content="https://timeline.salernohub.net/assets/img/og-image.svg">
	<meta name="twitter:image:alt" content="<?= htmlspecialchars(t('og_title')) ?>">
	<meta name="application-name" content="Timeline SalernoHub">
	<meta name="theme-color" content="#e9e5de" id="meta-theme-color">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<script>
		(function() {
			const savedTheme = localStorage.getItem('timeline_theme_v1');
			const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
			const theme = savedTheme || (prefersDark ? 'dark' : 'light');
			const color = (theme === 'dark') ? '#0b1220' : '#e9e5de';
			document.documentElement.classList.toggle('theme-dark', theme === 'dark');
			document.addEventListener('DOMContentLoaded', () => {
				document.body.classList.toggle('theme-dark', theme === 'dark');
				const meta = document.getElementById('meta-theme-color');
				if (meta) meta.setAttribute('content', color);
			});
		})();
	</script>
	<meta name="referrer" content="strict-origin-when-cross-origin">
		<script defer src="https://analytics.salernohub.net/script.js" data-website-id="1f14c9f6-0bbd-43e5-b917-115428e581ce"></script>
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "WebSite",
		"name": "Timeline SalernoHub",
		"url": "https://timeline.salernohub.net/",
		"inLanguage": "<?= htmlspecialchars($current_locale) ?>",
		"description": <?= json_encode(t('schema_description'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
		"potentialAction": {
			"@type": "SearchAction",
			"target": "https://timeline.salernohub.net/",
			"query-input": "required name=timeline"
		}
	}
	</script>
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "WebApplication",
		"name": "Timeline SalernoHub",
		"applicationCategory": "EducationalApplication",
		"operatingSystem": "Web",
		"url": "https://timeline.salernohub.net/",
		"inLanguage": "<?= htmlspecialchars($current_locale) ?>",
		"audience": {
			"@type": "PeopleAudience",
			"audienceType": "Students, Teachers, Professionals, Individuals"
		},
		"offers": {
			"@type": "Offer",
			"price": "0",
			"priceCurrency": "EUR"
		},
		"description": <?= json_encode(t('schema_app_description'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
		"featureList": [
			"Creazione di eventi con data, titolo e descrizione",
			"Aggiunta immagini agli eventi",
			"Esportazione e importazione JSON",
			"Modalità schermo intero per presentazioni",
			"Personalizzazione del titolo timeline"
		]
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
				"acceptedAnswer": {
					"@type": "Answer",
					"text": <?= json_encode(t('faq_a1'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
				}
			},
			{
				"@type": "Question",
				"name": <?= json_encode(t('faq_q2'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
				"acceptedAnswer": {
					"@type": "Answer",
					"text": <?= json_encode(t('faq_a2'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
				}
			},
			{
				"@type": "Question",
				"name": <?= json_encode(t('faq_q3'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
				"acceptedAnswer": {
					"@type": "Answer",
					"text": <?= json_encode(t('faq_a3'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
				}
			}
		]
	}
	</script>
	<link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime('assets/css/style.css'); ?>">
	<link rel="stylesheet" href="assets/css/style-mobile.css?v=<?= filemtime('assets/css/style-mobile.css'); ?>" media="(max-width: 900px)">
	<link rel="stylesheet" href="assets/css/style-desktop.css?v=<?= filemtime('assets/css/style-desktop.css'); ?>" media="(min-width: 901px)">
	<!-- PWA: Manifest -->
	<link rel="manifest" href="manifest.json">
</head>
