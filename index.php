<!DOCTYPE html>
<html>
<head>
<title>workout:.</title>
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
    ul {
        padding: 0;
    }
    li {
        list-style-type: none;
    }
    h1 {
        border-bottom: 3px solid black;
    }
</style>
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
    req.open("GET", "https://ericmarty.dev/wo/api");
    req.send();
</script>
<h1>wo</h1>

<p>Start workouts here.</p>

<div id="wo"></div>

</body>
</html>
