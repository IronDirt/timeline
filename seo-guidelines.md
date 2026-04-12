# Checklist SEO — Audit Completo per Progetti Web

> Istruzioni operative per l'agente AI. Segui ogni punto nell'ordine indicato.
> Per ogni problema trovato applica il fix direttamente, non limitarti a segnalarlo.

---

## 1. Meta-dati e Tag `<head>`

### Title

- Ogni pagina deve avere un `<title>` unico e descrittivo.
- Max **60 caratteri**. Deve contenere la keyword principale in modo naturale.
- Formato consigliato: `Brand – Keyword Principale` (coerente su tutte le lingue).
- Se il progetto è multilingua, verifica che ogni file di lingua abbia una chiave `seo_title` compilata e che il prefisso brand sia presente in tutte le varianti.

### Meta Description

- Max **160 caratteri**, unica per pagina.
- Deve includere keyword + call-to-action implicita.
- Se multilingua: verifica la chiave `seo_description` in ogni file di lingua.

### Meta Robots

- Le pagine principali devono avere `index, follow`.
- Pagine con parametri dinamici (es. `?room=`, `?id=`) → `noindex, nofollow`.
- Pagine secondarie funzionali (dual screen, debug, test) → `noindex, nofollow`.
- Le pagine legali (terms, privacy) → `index, follow` con priority bassa in sitemap.

### Canonical

- **Ogni pagina** deve avere `<link rel="canonical">` con URL assoluto.
- Le pagine con parametri dinamici devono puntare il canonical alla versione pulita.
- Verifica che i canonical non puntino a URL relativi.

### Hreflang (se multilingua)

- Ogni pagina indicizzabile deve avere `<link rel="alternate" hreflang="xx">` per tutte le lingue supportate.
- Includere sempre `hreflang="x-default"` che punta alla versione di default.
- I tag hreflang nel `<head>` devono corrispondere a quelli nella sitemap XML.

---

## 2. Gerarchia Header e Contenuto Crawlabile

### H1

- **Un solo `<h1>` per pagina.** Mai zero, mai più di uno.
- L'H1 deve contenere la keyword principale. Se il brand è visivo (logo/testo breve), aggiungi un `<span class="sr-only">` con il testo SEO completo dentro l'H1.
- Verifica che esista la classe `.sr-only` nel CSS (screen-reader only, visually hidden).

### H2–H3

- Usati per struttura logica dei contenuti, non per stile.
- Se il `<th>` di una tabella contiene testo importante, valuta di wrapparlo in un `<h2>` inline (`display:inline; font-size:inherit; font-weight:inherit; margin:0`).

### Contenuto testuale per i crawler

- Se la pagina è prevalentemente JS-driven (SPA/PWA), i crawler vedono poco testo.
- Aggiungi una `<section class="sr-only" aria-hidden="true">` prima del footer con:
  - H2 con il titolo SEO
  - Paragrafo con la meta description
  - Paragrafo con le features/keyword LSI del prodotto
- Aggiungi un blocco `<noscript>` con lo stesso contenuto, stilizzato, come fallback visibile per utenti senza JS e crawler.
- Se multilingua, tutte queste stringhe devono venire dal file di lingua (es. chiave `seo_features`).

---

## 3. Immagini

### Alt Text

- **Tutte** le immagini (`<img>`) devono avere `alt` descrittivo e localizzato.
- Evita alt generici come `"image"`, `"photo"`, `"Empty"` → usa la chiave di traduzione appropriata.
- Le icone decorative SVG inline devono avere `aria-hidden="true"` già presente.

### Dimensioni OG Image

- Se esiste `og:image`, aggiungere sempre `og:image:width`, `og:image:height` e `og:image:alt`.

---

## 4. Dati Strutturati (Schema.org / JSON-LD)

- Verifica che ogni pagina principale abbia un blocco `<script type="application/ld+json">`.
- **Tipo consigliato per web app:** `WebApplication` con: `name`, `url`, `description`, `applicationCategory`, `operatingSystem`, `offers` (price=0 se gratis), `inLanguage`.
- Per `audience` usa `PeopleAudience` con `audienceType` (stringa descrittiva), **non** array di oggetti `@type` organizzativi.
- Valida lo schema su https://validator.schema.org/ o con il Rich Results Test di Google.
- Per pagine con FAQ, recensioni, prodotti → aggiungere il tipo specifico se applicabile.

---

## 5. Open Graph e Social

- Ogni pagina indicizzabile deve avere: `og:type`, `og:site_name`, `og:title`, `og:description`, `og:url`, `og:image` (con width/height/alt), `og:locale`.
- Se multilingua: aggiungere `og:locale:alternate` per le altre lingue.
- Tag Twitter Card: `twitter:card` (summary_large_image), `twitter:title`, `twitter:description`, `twitter:image`, `twitter:image:alt`.

---

## 6. SEO Tecnico — Indicizzazione

### robots.txt

- Non deve bloccare risorse CSS/JS necessarie per il rendering.
- Bloccare solo: `/api/`, `/data/`, `/includes/`, file di test/debug, parametri dinamici.
- **L'URL della Sitemap deve essere assoluto** (es. `Sitemap: https://dominio.com/sitemap.xml`), non relativo.

### Sitemap XML

- Deve includere **tutte** le pagine indicizzabili (homepage per ogni lingua + pagine secondarie come terms/privacy).
- Ogni `<url>` deve avere `<loc>`, `<lastmod>`, `<changefreq>`, `<priority>`.
- Se multilingua: ogni URL deve avere i tag `<xhtml:link rel="alternate" hreflang="xx">` per tutte le lingue + `x-default`.
- Pagine legali: priority 0.3, changefreq monthly.
- Validare che nessuna pagina in sitemap abbia `noindex` nei meta.

### Redirect

- Nessuna catena di redirect (301 → 301).
- Nessun errore 404 su URL che ricevono link interni.

---

## 7. Performance SEO (Core Web Vitals)

### Font

- Usare Google Fonts con **range variable** (`wght@300..900`) invece di pesi discreti separati (`wght@300;400;500;600;700;900`) — singola richiesta, file più leggero.
- Sempre `<link rel="preconnect">` per `fonts.googleapis.com` e `fonts.gstatic.com` (con `crossorigin`).
- Usare `display=swap` per evitare FOIT.

### Script e risorse

- Non caricare librerie JS non necessarie nelle pagine secondarie (es. QRCode.js nella pagina terms).
- Tag analytics con `defer`.
- Script di terze parti con `crossorigin="anonymous" referrerpolicy="no-referrer"`.

---

## 8. Link Interni e Architettura

- Le pagine principali (homepage) devono ricevere link da tutte le pagine secondarie (es. breadcrumb, back link nel footer/header).
- Anchor text descrittivi — mai "clicca qui".
- Footer presente su tutte le pagine con link a: homepage, terms, contatti.
- Il footer deve usare `rel="noopener"` per i link `target="_blank"`.

---

## 9. PWA e Mobile

- Se PWA: il `manifest.json` deve avere `name`, `short_name`, `description` (con keyword), `start_url`, `scope`, `display`, icone multiple.
- Verifica `theme-color` e `apple-mobile-web-app-title` coerenti col brand.
- Il Service Worker deve essere registrato da root (`/sw.js`) per controllare tutto lo scope.

---

## Ordine di esecuzione consigliato

1. Scansiona tutti i file PHP/HTML per i tag `<head>` → verifica title, description, canonical, robots, hreflang, OG, Twitter Card
2. Controlla la gerarchia H1/H2 di ogni pagina
3. Cerca tutte le `<img>` e verifica gli alt text
4. Verifica JSON-LD
5. Controlla robots.txt e sitemap
6. Analizza performance font e script
7. Verifica link interni e architettura
8. Se multilingua: controlla coerenza di tutte le chiavi SEO in ogni file di lingua
