<?php
require_once 'Mail.php';
require_once('recaptchalib.php');
$parameters = parse_ini_file(__DIR__ ."/../.env.local");
$privatekey = $parameters['recaptcha_private_key'];

function getIP() {
	if (!empty($_SERVER['HTTP_CLIENT_IP']))  //check ip from share internet
           $IP=$_SERVER['HTTP_CLIENT_IP'];
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  //to check ip is pass from proxy
            $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
	else $IP=$_SERVER['REMOTE_ADDR'];
	return $IP;
}


if (isset($_POST['ftype'])) {
	if ($_POST['ftype'] == "er") {
		if (isset($_POST['urn'])) $urn = $_POST['urn'];
		else { 
			echo json_encode(array('status' => 1, 'message' => "An error occurred."));
			return;
		}

		$errortype = $_POST['type']." ".$_POST['othererror'];
		$errortext = $_POST['re_additional'];
		$email = $_POST['email'];
		if (strlen($email) <= 3) $email = "sunnah@iman.net";
		
		$resp = recaptcha_check_answer(
				$privatekey,
				$_POST["g-recaptcha-response"]
		);
	
		if (!$resp) {
				echo json_encode(array('status' => 2, 'message' => "The captcha was entered	"
					. "incorrectly. Please try again. $resp->error"));
		}
		else {
			$fullString = "Error type: ".$errortype."\n";
		  	$fullString = $fullString."Details: ".$errortext."\n";
		  	$fullString = $fullString."Submitted by ".$email."\n";
			$fullString = $fullString."IP address: ".getIP()."\n";
			$fullString = $fullString."\nhttp://sunnah.com/urn/".$urn."\n";

			$subject = "[Error Report] URN ".$urn;
			
			$headers = array (
              'From' => 'report@sunnah.com',
              'To' => 'sunnah@iman.net',
              'Reply-To' => $email,
              'Subject' => $subject);

            $smtpParams = array (
              'host' => 'email-smtp.us-west-2.amazonaws.com',
              'port' => 587,
              'auth' => true,
              'username' => $parameters['smtpUser'],
              'password' => $parameters['smtpPassword']
            );

            $mail = Mail::factory('smtp', $smtpParams);
            $result = $mail->send("sunnah@iman.net", $headers, $fullString);


			echo json_encode(array('status' => 0, 'message' => "Report submitted, thank you!"));
		}
	}
	elseif ($_POST['ftype'] == "cc") {
		
	}
}
?>
