// service-worker.js
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open("linea-temporale-v2").then((cache) => {
      return cache.addAll([
        "/",
        "/index.php",
        "/assets/css/style.css",
        "/assets/css/style-mobile.css",
        "/assets/css/style-desktop.css",
        "/assets/js/app.js",
        "/manifest.json",
        "/lang/it.js",
        "/lang/en.js",
        "/lang/es.js",
        "/lang/de.js",
        "/lang/fr.js",
        "/lang/pt.js",
        "/lang/ru.js",
        "/lang/tr.js",
        "/lang/ja.js",
        "/lang/zh.js",
        // aggiungi qui eventuali altre risorse statiche
      ]);
    }),
  );
});

self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    }),
  );
});
