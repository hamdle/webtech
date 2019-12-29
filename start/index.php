<!DOCTYPE html>
<html>
    <head>
        <title>wo</title>
        <link href="../css/styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <script>
            function requestListener() {
                data = JSON.parse(this.responseText);
                console.log(this.status);
                document.getElementById('program').innerHTML = data['Eric'];
            }

            var request = new XMLHttpRequest();
            request.addEventListener("load", requestListener);
            request.open("GET", "http://stg.ericmarty.local/wo/api/0/program");
            request.send();
        </script>

        <?php include dirname(__DIR__,1).'/html/start.html'; ?>
 
    </body>
</html>
