<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Workout app.</title>
    <link href="<?php echo $_ENV['ORIGIN']; ?>/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>

    <div class="dash__wrap">

        <div class="dash__display dash__display--header">
            <div class="header__body">
                Version <span id="version"></span>
            </div>
        </div>

        <div class="dash__display dash__display--log">
            <div class="dash__body">
                <div class="opt__title">
                    <span>Log</span>
                </div>
                <!-- Put custom modules here. -->
                <div id="log" class="log"></div>
            </div>
        </div>

    </div>

    <script>
        let api = "http://workout.local/api/";
        let site = "http://workout.local/";
    </script>
    <script src="/../js/components/version.js"></script>
    <script src="/../js/components/verifyuser.js"></script>
    <script src="/../js/components/log.js"></script>
    <script>
        Log.init();
        Version.init();
        // VerifyUser.onSuccess(function() {
        //     Log.init();
        //     Version.init();
        // });
    </script>

</body>
</html>