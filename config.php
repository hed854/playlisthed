<?php

// doesn't work with UTF-8 filenames
// Pls add trailing slash..
$outputDir = "playlists\\";
$mp3Root = "D:\\Music\\";
// TODO: config names cannot have spaces...
$config = array(
	'chipmusic' => array(
		$mp3Root . 'C64\\',
		$mp3Root . 'GameBoy\\'
		)
);
?>
