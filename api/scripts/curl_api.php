#!/usr/bin/php
<?php

/*
 * Run me:
 * $ ./curl_api.php auth
 */

// use getopt() to accept or set cookies TODO
$url = "http://api.workouts.think/".($argv[1] ?? "");
$cookies = "user=admin@localhost.com;pass=admin";
exec("curl -X GET \"".$url."\" -H \"Cookie: ".$cookies."\"", $output);

print "\nrequest\n".$url."\n";
print "\nresponse\n".print_r($output, true);

?>
