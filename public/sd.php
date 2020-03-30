<?php
	
	function url_encode($query) {
		/* This function takes a given URL and "cleans it up" to get rid of ugly 
	   character sequences */
		$retval = $query;
		$retval = preg_replace("/\s+/", " ", $retval);
		$retval = preg_replace("/-/", "-m-", $retval);
		$retval = preg_replace("/\"/", "-dq-", $retval);
		$retval = preg_replace("/\'/", "-sq-", $retval);
		$retval = preg_replace("/\*/", "-st-", $retval);
		$retval = preg_replace("/\//", "-s-", $retval);
		$retval = preg_replace("/\+/", "-p-", $retval);
		$retval = preg_replace("/ /", "-", $retval);
		return rawurlencode($retval);
	}

	if (isset($_GET['didyoumean'])) {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) $IP=$_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else $IP=$_SERVER['REMOTE_ADDR'];

//		$con = mysql_connect("localhost", "ansari") or die(mysql_error());
		$con = mysqli_connect("localhost", "webread") or die(mysqli_error($con));
		mysqli_select_db("searchdb") or die(mysqli_error($con));
		$query = "INSERT into didyoumean (query, suggestion, IP) values ('".addslashes($_GET['old'])."','".addslashes($_GET['query'])."','".$IP."')";
		mysqli_query($con, $query) or die(mysqli_error($con).$query);
		mysqli_close($con);
	}
	
	header('Location: /search/'.addslashes(url_encode(trim($_GET['query']))));
?>
