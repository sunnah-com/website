<?php

class SController extends Controller
{
	public function _auto_version($filename) {
		if (strpos($filename, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $filename))
    		return $filename;

  		$mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $filename);
  		return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $filename);
	}
}
