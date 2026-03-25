# Istruzioni Agente - Sviluppo Web Avanzato (PHP, PWA, Multi-Asset)

Operi su un'architettura a 3 livelli per siti performanti, multilingua e pronti per il mercato moderno (Dark Mode, PWA, Asset Separati).

## 1. Architettura e Automazione

### Livello 1: Direttiva (Strategia)
- Documenti in `directives/`: `seo_strategy.md`, `pwa_config.json`.
- **Copyright Dinamico**: Il footer deve sempre usare `<?php echo date('Y'); ?>` per l'aggiornamento automatico dell'anno.

### Livello 2: Orchestrazione (Logica e Temi)
- **Gestione Lingue**: Rilevamento tramite `?lang=`, sessione o cookie.
- **Dark/Light Mode**: Implementazione nativa tramite CSS Variables e `prefers-color-scheme`.
  ```css
  :root { --bg: #ffffff; --text: #000000; } /* Light */
  @media (prefers-color-scheme: dark) { :root { --bg: #121212; --text: #ffffff; } } /* Dark */
  ```
- **PWA (App Mobile/PC)**: Inserimento obbligatorio di `manifest.json` e un `service-worker.js` minimale per rendere il sito installabile.

### Livello 3: Esecuzione (Asset & Media)
- **Separazione CSS**: Caricamento condizionale per ottimizzare il rendering:
  ```html
  <link rel="stylesheet" href="assets/css/desktop.css" media="screen and (min-width: 769px)">
  <link rel="stylesheet" href="assets/css/mobile.css" media="screen and (max-width: 768px)">
  ```
- **Trasparenza Asset**: Obbligo di formato **WebP** o **PNG-24** per icone e loghi, garantendo il canale alpha (sfondo trasparente) per adattarsi a entrambi i temi (Dark/Light).

## 2. Struttura dei File Aggiornata

```text
project-root/
├── public_html/
│   ├── assets/
│   │   ├── css/
│   │   │   ├── desktop.css      # Layout PC
│   │   │   └── mobile.css       # Layout Smartphone
│   │   ├── img/                 # Solo SVG/WebP trasparenti
│   │   └── js/
│   │       └── sw.js            # Service Worker per PWA
│   ├── includes/
│   │   ├── header.php           # Meta tag PWA + CSS condizionali
│   │   └── footer.php           # Copyright automatico
│   ├── lang/                    # it.php, en.php, fr.php
│   ├── index.php                # Logic Router
│   └── manifest.json            # Configurazione App installabile
├── directives/
└── execution/
    └── optimize_assets.py       # Forza trasparenza e minificazione
```

## 3. Implementazione Tecnica Chiave

### PWA & Icone (Header.php)
Per rendere il sito scaricabile come App, includi sempre:
```html
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#121212">
<link rel="apple-touch-icon" href="assets/img/icon-192.png"> ```

### Copyright & Footer (Footer.php)
```php
<footer>
    <p>&copy; <?php echo date("Y"); ?> Nome Brand. Tutti i diritti riservati.</p>
</footer>
```

## 4. Loop di Lavoro Ottimizzato

1. **Setup**: Configura `manifest.json` e i due file CSS separati.
2. **Asset**: Verifica che ogni icona (SVG/PNG) non abbia bordi o sfondi bianchi "hardcoded".
3. **Sviluppo**: Applica le classi CSS basate su variabili per il supporto automatico Dark/Light mode.
4. **Validazione**: Controlla la responsività differenziata tra `desktop.css` e `mobile.css`.
5. **Deploy**: Attiva il Service Worker per abilitare il tasto "Installa App" sui browser.
