<?php

namespace app\modules\front\models;
use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $contacttext;
    public $verifyCode;

    public function rules()
    {
        return [
            ['contacttext', 'required'],
            ['name', 'default', 'value' => "None"],
            ['email', 'email'],
            ['verifyCode', 'captcha', 'captchaAction' => '/front/index/captcha'],
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
