<?php
require(__DIR__.'/../../vendor/autoload.php');
require_once(__DIR__.'/../components/UserIdentity.php');

class UserIdentityTest extends PHPUnit_Framework_TestCase
{
    public function test_authenticate_succeeds()
    {
        $this->execAuthenticate('demo', 'demo', true, UserIdentity::ERROR_NONE);
    }

    public function test_authenticate_fails_if_user_does_not_match()
    {
        $this->execAuthenticate('blah', 'demo', false, UserIdentity::ERROR_USERNAME_INVALID);
    }

    public function test_authenticate_fails_if_password_does_not_match()
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