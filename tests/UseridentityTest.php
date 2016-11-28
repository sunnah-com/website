<?php
require(__DIR__.'/../vendor/autoload.php');
require_once(__DIR__.'/../vendor/phpunit/phpunit/src/Framework/TestCase.php');
require_once(__DIR__.'/bootstrap.php');
require_once(__DIR__.'/../application/components/UserIdentity.php');

class UserIdentityTest extends PHPUnit_Framework_TestCase
{
    public function testAuthenticateSucceeds()
    {
        $this->execAuthenticate('demo', 'demo', true, UserIdentity::ERROR_NONE);
    }

    public function testAuthenticateFailsIfUserDoesNotMatch()
    {
        $this->execAuthenticate('blah', 'demo', false, UserIdentity::ERROR_USERNAME_INVALID);
    }

    public function testAuthenticateFailsIfPasswordDoesNotMatch()
    {
        $this->execAuthenticate('demo', 'blah', false, UserIdentity::ERROR_PASSWORD_INVALID);
    }

    private function execAuthenticate($user, $pass, $result, $errorCode) 
    {
        $userIdentity = new UserIdentity($user, $pass);
        $this->assertEquals($userIdentity->authenticate(), $result);
        $this->assertEquals($userIdentity->errorCode, $errorCode);
    }
}
?>