<?php

/**
  * Calls an HTTP POST function to verify if the user's guess was correct
  * @param string $privkey
  * @param string $response
  * @return boolean
  */
function recaptcha_check_answer($privkey, $response)
{
    if ($privkey == null || $privkey == '') {
        die("To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a>");
    }

    if ($response == null || $response == '') {
        die("Response from reCAPTCHA is required");
    }

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
                'secret' => $privkey,
                'response' => $response
        );

    $options = array(
        'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
        )
    );
    
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success=json_decode($verify);
    return $captcha_success->success;
}
