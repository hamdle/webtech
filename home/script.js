// home/script.js
//
//
// This page shows old workouts and lets the user start a new workout.

let api = "http://workout.local/api/";

VerifyUser.onSuccess(function() {
    Log.init();
}, "");
