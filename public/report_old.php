<?php
session_start();
$page_title = "Report Hadith";

$url = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
    <title><?php echo $page_title; ?></title>
    <!--<link href="/css/mainstyle.css" rel="stylesheet" type="text/css" />-->
</head>


<body bgcolor="#e7e2d9">

<?php
if (!isset($_POST['submit'])) {
	if (isset($_GET['coll'])) $collection = $_GET['coll'];
	if (isset($_GET['urn'])) $urn = $_GET['urn'];
	else {
		echo "An error occurred.";
		exit();
	}
}


    function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
            $IP=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
            $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else $IP=$_SERVER['REMOTE_ADDR'];

        return $IP;
    }



if (isset($_POST['submit'])) {
	$urn = $_POST['urn'];
	$errortype = $_POST['type'];
	$errortext = $_POST['errortext'];
	$email = $_POST['email'];
	if (strlen($email) <= 3) $email = "sunnah@iman.net";

	$flagError = false;
	if ($errortype == '') $flagError = true;


	if ($flagError) {
		echo "An error occurred. Please close this window and try again.";
	}
	else {
		  include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
		  $securimage = new Securimage();
		  if ($securimage->check($_POST['captcha_code']) == false) {
			echo "An error occurred with the captcha. Please close this window and try again.";
		  }
		  else {
			$fullString = "Error type: ".$errortype."\n";
		  	$fullString = $fullString."Details: ".$errortext."\n";
		  	$fullString = $fullString."Submitted by ".$email."\n";
			$fullString = $fullString."IP address: ".getIP()."\n";
			$fullString = $fullString."\nhttp://sunnah.com/urn/".$urn."\n";
		  	$to = "sunnah@iman.net";
		  	$subject = "[Error Report] URN ".$urn;
			$headers = "From: report@sunnah.com\r\nReply-To: $email";
		  	mail($to, $subject, $fullString, $headers);

			echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Report submitted. Thank you!</td></tr>
	</table>
	<p align=center>
                <a href=\"\" onclick=\"window.close()\">Close this window</a>
	</p>";
		  }
	}
}
else {

?>

	<form method="post" name="theform" action="<?php echo $url; ?>">

	<input type=hidden name=urn value=<?php echo $urn; ?>>

    <table width=85% align="center" cellpadding="0" cellspacing="0" border=0>
		<tr><td colspan=2>
			  <table width="80%" cellpadding=3 cellspacing="1" border=0 align="center">
			  <tr border=0><td colspan=2 border=0 align=center>
				Please indicate the type of error you wish to report:
			  </td></tr>
			 <tr height=15></tr>
			  </table>
		</td></tr>
		<tr><td colspan=2>
		  <table width="100%" cellpadding=3 cellspacing="1" border=0 align="center">
		    <tr>
      			<td border=0 width=10%></td>
				<td>
					<input name="type" type=radio value=mismatch />English/Arabic mismatch<br>
					<input name="type" type=radio value=spelling />Spelling mistake<br>
					<input name="type" type=radio value=incomplete />Incomplete text<br>
					<input name="type" type=radio value=translation />Mistranslation<br>
					<input name="type" type=radio value=other />Other (please add details below)<br><br>
                    Note that incorrectly grayed out chains of narration are not considered errors at this point.
		        </td>
      			<td border=0 width=10%></td>
		    </tr>
			<tr style="height:30px;"></tr>
			<tr align=center>
				<td border=0 colspan=3>
				Add any necessary details here: <br><br>
				<textarea name=errortext style="width: 400px; height: 200px;"></textarea></td>
			</tr>
			<tr style="height:30px;"></tr>
			<tr align=center>
				<td colspan=3>
					Your e-mail address: <input type=text size=30 name=email /> (optional)
				</td>
			</tr>
			<tr style="height:30px;"></tr>
			<tr align=center>
				<td colspan=3>
					<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
					Enter the captcha shown:
					<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">[change]</a>
					<br>
					<input type="text" name="captcha_code" size="10" maxlength="6" />
				</td>
			</tr>
		  </table>
		</td></tr>
		<tr height=15></tr>
		 <tr>
			<td colspan=2>
					    <p align="center"><input type="submit" name="submit" value="Submit"></p>
    		</td>
		 </tr>
	</table>

	</form>
<?php

}

?>

<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://sunnah.quran.com/piwik/" : "http://sunnah.quran.com/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://sunnah.quran.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>

<script type="text/javascript">
var sc_project=7148282; 
var sc_invisible=1; 
var sc_security="63a57073"; 
</script>

<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script><noscript><div
class="statcounter"><a title="drupal statistics"
href="http://statcounter.com/drupal/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/7148282/0/63a57073/1/"
alt="drupal statistics" ></a></div></noscript>

</body>
</html>
