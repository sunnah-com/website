<?php

namespace app\components\search\engines;

use yii\base\BaseObject;

class SolrConnection extends BaseObject
{
    public $server;
    public $username;
    public $password;
    private $context;

    public function init() {
        parent::init();
        $opts = array(
            'http' => array(
                'header' => 'Authorization: Basic ' . base64_encode($this->username.':'.$this->password)
            )
        );
        $this->context = stream_context_create($opts);
    }

    public function sendRequest($url)
    {
        return file_get_contents("{$this->server}{$url}", false, $this->context);
    }
}
