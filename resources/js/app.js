// import './bootstrap';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';

// Nangkep sinyal dari Reverb
window.Echo.channel('chat-channel')
    .listen('.message.sent', (e) => {
        console.log('🔥 BOOM! Pesan masuk Han:', e);
        alert('Ada pesan baru masuk ke LearnLoop!');
    });

