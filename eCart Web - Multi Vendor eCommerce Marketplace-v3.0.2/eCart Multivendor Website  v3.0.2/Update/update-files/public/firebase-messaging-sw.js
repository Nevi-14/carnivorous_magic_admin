/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/

importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');


/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
  apiKey: "AIzaSyDQnnO7bXnjvEBj_YKoLRFsa4zg9CdJyG0",
  authDomain: "ecart-multivendor-dev.firebaseapp.com",
  projectId: "ecart-multivendor-dev",
  storageBucket: "ecart-multivendor-dev.appspot.com",
  messagingSenderId: "605790780274",
  appId: "1:605790780274:web:2d6efc2f76add965e17beb",
  measurementId: "G-3QT4V9CV62"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log("[firebase-messaging-sw.js] Received background message111 ",payload,);
  
        const string = payload.data.data;

var obj = JSON.parse( payload.data.data );
var type = obj.type;
        const noteTitle = obj.title;
  /* Customize notification here */
  const notificationTitle= obj.title;
if(type === 'order'){
  var noteOptions = {
            body: obj.message,
            icon: obj.image,
            data:{
            time: new Date(Date.now()).toString(),
            click_action: "/orders"
        }

        };
       
    }else{
      var noteOptions = {
            body: obj.message,
            icon: obj.image,
            data:{
            time: new Date(Date.now()).toString(),
            click_action: "/notification"
        }

        };  
       
    }

  return self.registration.showNotification(
    notificationTitle,
    noteOptions,
  );
});
self.addEventListener('notificationclick', function(event) {

   var action_click=event.notification.data.click_action;
  event.notification.close();

  event.waitUntil(
    clients.openWindow(action_click)
  );
});