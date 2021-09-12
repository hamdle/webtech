// home/script.js
//
//
// This page shows old workouts and lets the user start a new workout.

import { VerifyUser } from "../javascript/components/verifyuser.js";
import { Log } from "../javascript/components/log.js";

VerifyUser.onSuccess(function() {
    Log.init();
});
