<!doctype HTML>
<html>
<head>
<meta charset="utf-8">
<title>Playlisthed</title>
<link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<?php
require_once('config.php');
?>
<div class="container" style="text-align:center">
<img src="img/title.png"/>
<form name="input" action="xmpPlaylistCreate.php" method="post">
Playlist type:
<select name="type">
<?php foreach($config as $type => $content){ echo "<option value=" .$type .">" .$type ."</option>";}?>
</select>

<br/>
Playlist length:
<input type="text" name="length">
<br/>
<input type="submit" value="Generate!" class="btn btn-primary">
</form>
</div>
</html>
