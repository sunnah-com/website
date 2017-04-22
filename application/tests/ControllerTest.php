<?php
require(__DIR__.'/../../vendor/autoload.php');
require_once(__DIR__.'/../modules/default/models/Util.php');
require_once(__DIR__.'/../components/Controller.php');

class MockController extends Controller
{
    public function __construct($id) {
    	parent::__construct($id, NULL);

        $this->_pageNames = array("p1", "p2");
        $this->_pageLinks = array("l1", "l2");
    }
}

class ControllerTest extends PHPUnit_Framework_TestCase
{
    public function test_titleString_concatinates_pages()
    {
        $controller = new MockController("id");
        $this->assertEquals("p2 - p1 - ", $controller->titleString());
    }

    public function test_pathString_creates_links()
    {
        $controller = new MockController("id");
        $this->assertEquals('<a href="l1">p1</a> &#187; p2', $controller->pathString());
    }
}
?>