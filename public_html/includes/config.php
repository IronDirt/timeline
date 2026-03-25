<?php
declare(strict_types=1);

// ── Lingue supportate ──────────────────────────────────────────────
$allowed_langs = ['it', 'en', 'es', 'de', 'fr', 'pt', 'ru', 'tr', 'ja', 'zh'];
$default_lang  = 'it';

// ── Rilevamento lingua ─────────────────────────────────────────────
$lang_code = $_GET['lang'] ?? ($_COOKIE['timeline_lang'] ?? $default_lang);

if (!in_array($lang_code, $allowed_langs, true)) {
    $lang_code = $default_lang;
}

// Salva preferenza lingua in cookie (30 giorni)
if (!headers_sent()) {
    setcookie('timeline_lang', $lang_code, [
        'expires'  => time() + 86400 * 30,
        'path'     => '/',
        'httponly'  => false,
        'samesite'  => 'Lax',
    ]);
}

// ── Caricamento file lingua PHP ────────────────────────────────────
$lang_file = __DIR__ . '/../lang/' . $lang_code . '.php';

if (is_file($lang_file)) {
    $lang = include $lang_file;
} else {
    $lang = include __DIR__ . '/../lang/' . $default_lang . '.php';
    $lang_code = $default_lang;
}

// ── Helper per traduzione ──────────────────────────────────────────
function t(string $key): string {
    global $lang;
    return $lang[$key] ?? $key;
}

// ── Mappa locale per OG/SEO ────────────────────────────────────────
$locale_map = [
    'it' => 'it_IT', 'en' => 'en_US', 'es' => 'es_ES',
    'de' => 'de_DE', 'fr' => 'fr_FR', 'pt' => 'pt_PT',
    'ru' => 'ru_RU', 'tr' => 'tr_TR', 'ja' => 'ja_JP',
    'zh' => 'zh_CN',
];
$current_locale = $locale_map[$lang_code] ?? 'it_IT';

// ── Directory per timeline condivise ───────────────────────────────
function timeline_storage_dir(): string {
    return __DIR__ . '/../shared-timelines';
}

function timeline_base_url(): string {
    $scheme = 'http';
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $scheme = 'https';
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        $scheme = explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO'])[0] === 'https' ? 'https' : $scheme;
    }

    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $path = $_SERVER['PHP_SELF'] ?? '/index.php';

    return $scheme . '://' . $host . $path;
}

function timeline_generate_id(int $bytes = 6): string {
    return bin2hex(random_bytes($bytes));
}

function timeline_build_share_urls(string $timelineId, string $adminToken, string $viewerToken): array {
    $baseUrl = timeline_base_url();

    return [
        'adminUrl'  => $baseUrl . '?timeline=' . rawurlencode($timelineId) . '&admin=' . rawurlencode($adminToken),
        'viewerUrl' => $baseUrl . '?timeline=' . rawurlencode($timelineId) . '&view=' . rawurlencode($viewerToken),
    ];
}
