<?php

namespace app\modules\front\models;
use Yii;
use yii\base\Model;

use kekaadrenalin\recaptcha3\ReCaptchaValidator;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $contacttext;
    public $reCaptcha;

    public function rules()
    {
        return [
            ['contacttext', 'required'],
            ['name', 'default', 'value' => "None"],
            ['email', 'email'],
            [['reCaptcha'], ReCaptchaValidator::class, 'acceptance_score' => 0],
        ];
    }



    public function sendMessage() {
        $timestamp = date("H:i:s M d Y");
        $fullString = "Message: ".$this->contacttext."\n";
        $fullString .= "Submitted by $this->name (".$this->email.") at $timestamp\n";
        $fullString .= "IP address: ".Yii::$app->getRequest()->getUserIP()."\n";

        $replyto = Yii::$app->params['adminEmail'];
        if (!is_null($this->email) && $this->email !== '') { $replyto = $this->email; }

        return Yii::$app->mailer->compose()
                         ->setFrom('contact@sunnah.com')
                         ->setTo(Yii::$app->params['adminEmail'])
                         ->setReplyTo($replyto)
                         ->setSubject("[Contact] Sunnah.com - $timestamp")
                         ->setTextBody($fullString)
                         ->send();
    }
}
