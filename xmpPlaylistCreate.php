<?php

require_once('lib/xmpPlaylist.class.php');
require_once('config.php');
$type = $_POST['type'];
$length = $_POST['length'];
if(!is_numeric($length))  throw new Exception("Length must be an int");

// generate playlist
$sourceDirList = $config[$type];
$playlist = new xmpPlaylist('out\\', $sourceDirList, $type, true);
$playlist->fill($length);

// download playlist
$file = $playlist->getLocation();
header("Content-Type: application/octet-stream; "); 
header("Content-Transfer-Encoding: binary"); 
header("Content-Length: ". filesize($file).";"); 
header("Content-disposition: attachment; filename=" . $file);
readfile($file);
?>
