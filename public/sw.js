// Service worker minimal, necessaire pour rendre l'app installable.
// Ne met rien en cache pour l'instant (pas de mode hors-ligne complexe).

self.addEventListener('install', () => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', () => {
    // Laisse passer toutes les requetes normalement
});