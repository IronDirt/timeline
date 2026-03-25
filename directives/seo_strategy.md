# Strategia SEO - Timeline SalernoHub

## Panoramica

Timeline SalernoHub è un'applicazione web multilingua per la creazione di linee temporali personalizzate. Il sito supporta **10 lingue**: IT, EN, ES, DE, FR, PT, RU, TR, JA, ZH.

## Gerarchia delle Lingue

1. **Italiano (IT)** — Lingua primaria e di default
2. **Inglese (EN)** — Lingua secondaria, fallback globale
3. **Altre** — ES, DE, FR, PT, RU, TR, JA, ZH

## URL Strategy

- Default (IT): `https://timeline.salernohub.net/`
- Altre lingue: `https://timeline.salernohub.net/?lang=xx`
- Il parametro `lang` viene salvato in cookie per persistenza

## Tag SEO i18n

### hreflang
Ogni pagina include tag `<link rel="alternate" hreflang="xx">` per tutte le 10 lingue più `x-default` che punta alla versione italiana.

### Meta Tag
- `<html lang="xx">` — impostato dinamicamente dal server PHP
- `og:locale` — mappato alla lingua corrente
- Title, description, OG tags — tutti tradotti da `$lang[]`

### Structured Data (JSON-LD)
- `inLanguage` — impostato alla lingua corrente
- FAQ — tradotta nella lingua corrente

## Mercati Target

| Priorità | Lingua | Mercato |
|----------|--------|---------|
| Alta     | IT     | Italia  |
| Alta     | EN     | Globale |
| Media    | ES     | Spagna, LATAM |
| Media    | FR     | Francia, Africa francofona |
| Media    | DE     | Germania, Austria, Svizzera |
| Media    | PT     | Portogallo, Brasile |
| Bassa    | RU     | Russia, CSI |
| Bassa    | TR     | Turchia |
| Bassa    | JA     | Giappone |
| Bassa    | ZH     | Cina, Taiwan |
