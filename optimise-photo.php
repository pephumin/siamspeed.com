<?php
global $jpegquality;
global $pngquality;
$path = '/www/default/siamspeed.com/attachments';
$jpegquality = 80;
$pngquality = 9;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Optimize JPEG Files with PHP</title>
</head>
<body>

<?php
$ar = getDirectorySize($path);
echo '
<h1>'.$path.'</h1>
<dl>
	<dt>Total Size:</dt>
	<dd>'.sizeFormat($ar['size']).'</dd>
	<dt>Number of files:</dt>
	<dd>'.$ar['count'].'</dd>
	<dt>Number of subdirectories:</dt>
	<dd>'.$ar['dircount'].'</dd>
</dl>';
echo "\n<ul>";
$done = recursedir($path);
echo "\n</ul>";
if ($done) {
	$as = getDirectorySize($path);
	echo '<div>The images have all been resampled to JPEG 80-quality photos.</div>
	<h1>'.$path.'</h1>
	<dl>
		<dt>Total Size:</dt>
		<dd>'.sizeFormat($as['size']).'</dd>
		<dt>Number of files:</dt>
		<dd>'.$as['count'].'</dd>
		<dt>Number of subdirectories:</dt>
		<dd>'.$as['dircount'].'</dd>
	</dl>
	<h2>The directory is '.sizeFormat(($ar['size']-$as['size'])).' smaller than it was before the optimization.</h2>';
}
else {
	echo '<h1>The function did not complete successfully.</h1>';
}

function recursedir($path,$print=true) {
	if ($handle = opendir($path)) {
		while (false !== ($file=readdir($handle))) {
			if ($print) { echo "\n<li>$path/$file"; }
			if (!is_dir($path.'/'.$file) && $file != '.' && $file != '..') {
				$start = filesize($path.'/'.$file);
				if (exif_imagetype($path.'/'.$file) == IMAGETYPE_JPEG) { optimize_jpeg($path.'/'.$file); }
				elseif (exif_imagetype($path.'/'.$file) == IMAGETYPE_PNG) { optimize_png($path.'/'.$file); }
				$end = filesize($path.'/'.$file);
				if ($print) { echo "</li>"; }
			}
			elseif (is_dir($path.'/'.$file) && $file != '.' && $file != '..') {
				if ($print) { echo "\n<ul>"; }
				recursedir($path.'/'.$file);
				if ($print) { echo "</ul>"; }
			}
		}
	}
	return true;
}

function optimize_jpeg($file) {
	if (!isset($GLOBALS['jpegquality']) || !is_numeric($GLOBALS['jpegquality'])) { return false; }
	if ($GLOBALS['jpegquality'] > 100 || $GLOBALS['jpegquality'] < 0) { $GLOBALS['jpegquality'] = 80; }
	list($w,$h) = @getimagesize($file);
	if (empty($w) || empty($h)) { return false; }
	$src = imagecreatefromjpeg($file);
	$tmp = imagecreatetruecolor($w, $h);
	imagecopyresampled($tmp,$src, 0, 0, 0, 0, $w, $h, $w, $h);
	$src = imagejpeg($tmp, $file, $GLOBALS['jpegquality']);
	imagedestroy($tmp);
	return true;
}

function optimize_png($file) {
	if (!isset($GLOBALS['pngquality']) || !is_numeric($GLOBALS['pngquality'])) { return false; }
	if ($GLOBALS['pngquality'] > 9 || $GLOBALS['pngquality'] < 0) { $GLOBALS['pngquality'] = 9; }
	list($w,$h) = @getimagesize($file);
	if (empty($w) || empty($h)) { return false; }
	$src = imagecreatefrompng($file);
	$tmp = imagecreatetruecolor($w, $h);
	imagecopyresampled($tmp,$src, 0, 0, 0, 0, $w, $h, $w, $h);
	$src = imagepng($tmp, $file, $GLOBALS['pngquality']);
	imagedestroy($tmp);
	return true;
}

function getDirectorySize($path) {
  $totalsize = 0;
  $totalcount = 0;
  $dircount = 0;
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      $nextpath = $path . '/' . $file;
      if ($file != '.' && $file != '..' && !is_link($nextpath)) {
        if (is_dir($nextpath)) {
          $dircount++;
          $result = getDirectorySize($nextpath);
          $totalsize += $result['size'];
          $totalcount += $result['count'];
          $dircount += $result['dircount'];
        } elseif (is_file($nextpath)) {
          $totalsize += filesize($nextpath);
          $totalcount++;
        }
      }
    }
  }
  closedir ($handle);
  $total['size'] = $totalsize;
  $total['count'] = $totalcount;
  $total['dircount'] = $dircount;
  return $total;
}

function sizeFormat($size) {
	if ($size<1024) { return $size." bytes"; }
	else if ($size<(1024*1024)) { $size = round($size/1024,1); return $size." KB"; }
	else if ($size<(1024*1024*1024)) { $size = round($size/(1024*1024),1); return $size." MB"; }
	else { $size = round($size/(1024*1024*1024),1); return $size." GB"; }
}
?>

</body>
</html>
