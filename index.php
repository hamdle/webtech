<!DOCTYPE html>
<html>
    <head>
        <title>wo</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <script>
            function requestListener() {
                $data = JSON.parse(this.responseText);
                console.log($data);
                document.getElementById('wo').innerHTML = $data['Eric'];
            }

            var req = new XMLHttpRequest();
            req.addEventListener("load", requestListener);
            req.open("GET", "http://stg.ericmarty.local/wo/api");
            req.send();
        </script>

        <?php include __DIR__.'/html/home.html'; ?>
 
    </body>
</html>
