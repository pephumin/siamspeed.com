<?php

require("API/cloudflare.class.php");
$cf = new cloudflare_api("phumin@sawasdee.org", "1bfe8b31ad3874ee49ba7c2086d1d0402e2ed");
$response = $cf->stats("siamspeed.com", $cf::INTERVAL_30_DAYS);
//printf($response);
echo $response;

?>
