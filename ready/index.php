<!DOCTYPE html>
<html>
    <head>
        <title>wo</title>
        <link href="../css/styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        
        <?php include __DIR__.'/template.html'; ?>

        <script>
            function requestListener() {
                responseData = JSON.parse(this.responseText);
                console.log(this.status);
                console.log(responseData);
                document.getElementById('program').outerHTML = 'Welcome, ' + responseData['program'];
            }

            var request = new XMLHttpRequest();
            request.addEventListener("load", requestListener);
            request.open("GET", "http://stg.ericmarty.local/wo/api/22/programs/new");
            request.send();
        </script>
    </body>
</html>
