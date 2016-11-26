<?php
//Send some headers to keep the user's browser from caching the response.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=utf-8");

//Get our database abstraction file
require('database.php');
///Make sure that a value was sent.
if (isset($_GET['search']) && $_GET['search'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$search = addslashes($_GET['search']);
	//Get every page title for the site.
	$suggest_query = db_query("SELECT distinct(Phrase) as suggest FROM testAutoComplete WHERE Phrase like('" . 
		$search . "%') ORDER BY Phrase LIMIT 0, 10");
	while($suggest = db_fetch_array($suggest_query)) {
		//Return each page title seperated by a newline.
		echo $suggest['suggest'] . "\n";
	}
}
?>
