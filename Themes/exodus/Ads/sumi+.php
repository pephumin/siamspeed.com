<?php

//$a = array("banner1.jpg","banner2.jpg","banner3.jpg","banner4.jpg");
//$random_keys = array_rand($a,4);
//$banner = $a[$random_keys[1]];

$no = rand(1,4);

?>


<div class="container">

<div class="row">

<div class="center-block">

<a href="/optout.php?b=<?php echo $no; ?>"><img src="/Themes/exodus/Ads/Sumi+/banner<?php echo $no; ?>.jpg" class="img-responsive center-block" alt="Sumi+"></a>

</div>

</div>

</div>