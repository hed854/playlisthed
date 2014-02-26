<?php

require_once('PlaylistInterface.class.php');

class xmpPlaylist
{
	private $nbEntries;
	private $files = array();
	private $playlist;
	private $sources = array();
	private $playlistName;
	private $outputDir;
	
	// TODO :
	// - handle OGG, MPGA, XM, MOD...

	public function __construct($outputDir, $sourceDir, $namePrefix, $isRecursive)
	{
		// Checking parameters
		if(is_dir($outputDir))
		{
			$this->outputDir = $outputDir;
		}
	
		$this->sourceDir = $sourceDir;
		// Create all
		$this->setPlaylistName($namePrefix . date('dmY'));
		$this->playlist = fopen($this->outputDir .$this->playlistName, 'w');
		if($this->playlist)
		{
			$this->setNbEntries(0);

			// init the file with header
			$res = fprintf($this->playlist, "[playlist]\n");
		}
	}
	
	public function fill($fileLimit)
	{
		$count = 0;
		$res = fprintf($this->playlist, "numberofentries=" .$fileLimit."\n");
		while( $count < $fileLimit)
		{
			// choose source
			// TODO: utf8_decode because meh
			$pickedSource = utf8_decode($this->sourceDir[mt_rand(0, sizeof($this->sourceDir) - 1)]);
			
			// choose directory in source
			if(is_dir($pickedSource))
			{
				$file = new xmpFile($pickedSource);
				$res = fprintf($this->playlist, 'file' .$count .'=' .$file->getFile() ."\n");
				$res2= fprintf($this->playlist, 'title' .$count .'=' .$file->getTitle() ."\n");
				$res2= fprintf($this->playlist, 'length' .$count .'=' .$file->getLength()."\n");
				//var_dump($file->getFile() ."\n");
				$count++;
			}
			else 
			{
				echo 'stopping at ' .$pickedSource ."\n";
				exit(0);
			}
			
		}
	}
	
	public function addFile(xmpFile $file)
	{
		$this->setNbEntries = $this->nbEntries ++;
	}
	
	public function setPlaylistName($name)
	{
		$this->playlistName = $name .'.pls';
	}
	
	private function setNbEntries($nbEntries)
	{
		$this->nbEntries = $nbEntries;
	}
	
	public function getLocation()
	{
		return $this->outputDir .$this->playlistName;
	}
	public function getPlaylistName()
	{
		return $this->playlistName;
	}
}

class xmpFile
{
	private $file;
	private $title;
	private $length;
	
	public function __construct($dir)
	{
		$this->setLength();
		$this->setFile($this->randomFile($dir, 'mp3|ogg|mod|s3m|xm|it'));
		$this->setTitle(basename($this->getFile()));
	}
	
	public function getFile()
	{
		return $this->file;
	}	
	
	public function getLength()
	{
		return $this->length;
	}	
	
	public function getTitle()
	{
		return $this->title;
	}
	
	protected function setLength()
	{
		$this->length = 0;
	}
	
	protected function setTitle($title)
	{
		$this->title =$title;
	}
	
	protected function setFile($file)
	{
		$this->file = $file;
	}
	
	public function randomFile($folder='', $extensions='.*')
	{
    // fix path:
    $folder = trim($folder);
    $folder = ($folder == '') ? '.\\' : $folder;
 
    // check folder:
    if (!is_dir($folder)){ die('invalid folder given!'); }
 
    // create files array
    $files = array();

    // open directory
		$di = new RecursiveDirectoryIterator($folder);
		foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
			if (!preg_match('/^\.+$/', $file) and preg_match('/\.('.$extensions.')$/i', $file))
			{
					$files[] = $filename;
			}
 
		}
   
    if (count($files) == 0){
        die('No files where found :-(');
    }
 
    // seed random function:
    mt_srand((double)microtime()*1000000);
 
    // get an random index:
    $rand = mt_rand(0, count($files)-1);
 
    // check again:
    if (!isset($files[$rand])){
        die('Array index was not found! very strange!');
    }
 
    // return the random file:
    return $files[$rand];
 
	}


}

?>
