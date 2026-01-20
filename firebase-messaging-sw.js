importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js");

firebase.initializeApp({
  apiKey: "AIzaSyA-hgt6lhmMAk2uSqLQ4TUjt3WXOkoR6AU",
  authDomain: "noga-foods-brasil.firebaseapp.com",
  projectId: "noga-foods-brasil",
  storageBucket: "noga-foods-brasil.appspot.com",
  messagingSenderId: "48021597218",
  appId: "1:48021597218:web:4865d6ecc40e9445c5ee7b",
  databaseURL: "G-L4G5S8Y2EB",
});

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    const promiseChain = clients
        .matchAll({
            type: "window",
            includeUncontrolled: true
        })
        .then(windowClients => {
            for (let i = 0; i < windowClients.length; i++) {
                const windowClient = windowClients[i];
                windowClient.postMessage(payload);
            }
        })
        .then(() => {
            const title = payload.notification.title;
            const options = {
                body: payload.notification.score
              };
            return registration.showNotification(title, options);
        });
    return promiseChain;
});
self.addEventListener('notificationclick', function (event) {
    console.log('notification received: ', event)
});