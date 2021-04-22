<?php

	if (!is_null($splpage)) {
		$aboutpath = "about/".$splpage.".php";
	}
	else $aboutpath = "about/".$collectionName.".php";
 
	$path = dirname(__FILE__)."/".$aboutpath;
	if (realpath($path)) {
		echo "<h1 class=abouttitle>".$collection->englishTitle."</h1>";
		include $aboutpath;
	}
	else echo "Either the collection name is invalid, or we haven't yet added information for this collection yet. Please bear with us. ".$aboutpath;
?>
