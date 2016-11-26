<?php session_start(); 
require_once 'Mail.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN"/>
  <meta name="description" content="Hadith of the Prophet Muhammad (saws) in English and Arabic"/>
  <meta name="keywords" content="hadith, sunnah, bukhari, muslim, sahih, sunan, tirmidhi, nawawi, holy, arabic, iman, islam, Allah, book, english"/>
  <meta name="Charset" content="UTF-8"/> 
  <meta name="Distribution" content="Global"/>
  <meta name="Rating" content="General"/>
 
  <link href="/css/all.css" media="screen" rel="stylesheet" type="text/css" />

  <link rel="shortcut icon" href="/favicon.ico" >

  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>

  	<script>
		</script>
  <script src="/js/sunnah.js"></script>
 
  <title>
	Contact - 	Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
</head>

<body>
<div id="site">

	<div id="header">
    	<div id="toolbar">
       		<div id="toolbarRight">
				            <a href="http://quran.com">Qur'an</a> |
            <a href="http://corpus.quran.com/wordbyword.jsp">Word by Word</a> |
            <a href="http://quranicaudio.com">Audio</a> |
            <a href="http://sunnah.com"><b>sunnah.com</b></a> |
            <a href="http://salah.com">Prayer Times</a> |
            <a href="http://android.quran.com">Android</a> |
            <a href="http://beta.quran.com" style="position: relative; padding-right: 18px;">beta.quran.com <img style="position: absolute; top: -6px; right: -10px;" src="/images/labs.png"></a>

	        </div>
    	</div>

		<a href="http://sunnah.com"><div id="banner" class=bannerTop></div></a>
		<!-- <a href="#"><div id=back-to-top></div></a> -->
		
<div id=search>
    <a class="searchtipslink">Search Tips</a>
    <div id="searchbar" class="sblur">
        <form name="searchform" action="/search_redirect.php" method=get id="searchform">
            <input type="text" class="searchquery" name=query value="Search …" />
            <input type="image" src="/images/search.png" class="searchsubmit" value="" />
        </form>
    </div>

	<div id="searchtips">
		<div class=clear></div>
		<b>Quotes</b> e.g. "pledge allegiance"<br>
		Searches for the whole phrase instead of individual words
		<p>
		<b>Wildcards</b> e.g. test*<br>
		Matches any set of one or more characters. For example test* would result in test, tester, testers, etc.
		<p>
		<b>Fuzzy Search</b> e.g. swore~<br>
		Finds terms that are similar in spelling. For example swore~ would result in swore, snore, score, etc.
		<p>
		<b>Term Boosting</b> e.g. pledge^4 hijrah<br>
		Boosts words with higher relevance. Here, the word <i>pledge</i> will have higher weight than <i>hijrah</i>
		<p>
		<b>Boolean Operators</b> e.g. ("pledge allegiance" OR "shelter) AND prayer<br>
		Create complex phrase and word queries by using Boolean logic.
		<p>
		<a href="/searchtips">More ...</a>
	<div class=clear></div>
	</div>
</div>
		<div class=clear></div>
		<div class=crumbs><a href="/">Home</a> &#187; Contact</div><div class=clear></div>	</div>

	<div class=clear></div>
	<div id="topspace"></div>

	<div id=nonheader" style="position: relative;">
	<div class="sidePanelContainer">
		<div style="height: 1px;"></div>
		<div id="sidePanel">
			    	</div>
	</div><!-- sidePanelContainer close -->
	<div class="mainContainer"><div id="main">
	        <div class=clear></div>
<?php
$url = $_SERVER['SCRIPT_NAME'];

function getIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $IP=$_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $IP=$_SERVER['REMOTE_ADDR'];

    return $IP;
}

if (isset($_POST['submit'])) {
    $contacttext = $_POST['contacttext'];
    $email = $_POST['email'];
    $name = $_POST['name1'];

    $flagError = false;
    if (strlen($contacttext) < 2) $flagError = true;


    if ($flagError) {
        echo "An error occurred. Please try again.";
    }
    else {
          include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
          $securimage = new Securimage();
          if ($securimage->check($_POST['captcha_code']) == false) {
            echo "An error occurred with the captcha. Please try again.";
          }
          else {
            $timestamp = date("H:i:s M d Y", time());
            $fullString = "Message: ".$contacttext."\n";
            $fullString = $fullString."Submitted by $name (".$email.") at $timestamp\n";
            $fullString = $fullString."IP address: ".getIP()."\n";

			$headers = array (
			  'From' => 'contact@sunnah.com',
			  'To' => 'sunnah@iman.net',
			  'Reply-To' => $email,
			  'Subject' => "[Contact] Sunnah.com - $timestamp");
			
			$sesCreds = parse_ini_file('../application/sesCreds.txt');

			$smtpParams = array (
			  'host' => 'email-smtp.us-west-2.amazonaws.com',
			  'port' => 587,
			  'auth' => true,
			  'username' => $sesCreds['smtpUser'],
			  'password' => $sesCreds['smtpPassword']
			);

			$mail = Mail::factory('smtp', $smtpParams);
			$result = $mail->send("sunnah@iman.net", $headers, $fullString);

			if (PEAR::isError($result)) {
            echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>There was an error and your message was not sent. $result->getMessage()</td></tr>
    </table>";
			} else {
            echo "
    <table width=75% align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr><td align=center>Your message has been sent. Thank you!</td></tr>
    </table>";
			}
          }
    }
}
else {

?>


    <form method="post" name="theform" action="/contact">
    <table width=85% align="center" cellpadding="0" cellspacing="0" border=0>
        <tr><td>
          <table width="70%" cellpadding=3 cellspacing="1" border=0 align="center">
            <tr style="height:30px;"></tr>
            <tr align=center>
                <td border=0 colspan=2>
                We would love to hear any comments, suggestions, or feedback.<br>
                Please enter your message in the box below: <br><br>
                <textarea name=contacttext style="width: 400px; height: 200px; background-color: #eee;"></textarea></td>
            </tr>
            <tr style="height:10px;"></tr>
            <tr>
                <td>Your name:</td>
                <td><input type=text size=30 name=name1 /></td>
            </tr>
            <tr>
                <td>Your e-mail address:</td>
                <td><input type=text size=30 name=email /></td>
            </tr>
            <tr style="height:30px;"></tr>
            <tr align=center>
                <td colspan=2>
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

	<div class="clear"></div>
    </div><!-- main close -->
	</div> <!-- mainContainer close -->
	<a href="#"><div id=back-to-top></div></a>
	<div class="clear"></div>
	</div> <!-- nonheader close -->
    
<div class=footer>
	<a href="/about">About</a> |
	<a href="/news">News</a> |
	<a href="/contact">Contact</a> |
	<a href="/support">Support</a>
<div class=clear></div>
</div>

<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://sunnah.com/piwik/" : "http://sunnah.com/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://sunnah.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>

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
	<div class="clear"></div>

</div><!-- site div close -->
</body>
</html>

