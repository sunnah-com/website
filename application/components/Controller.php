<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
//require_once("../modules/default/models/Util.php");

class Controller extends CController
{

	public function __construct($id, $module = NULL) {
		parent::__construct($id, $module);
		$this->util = new Util();
		$this->_viewVars = new StdClass();
	}

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	protected $_viewVars;
	protected $_pageType;
	protected $_errorMsg;

	protected $_pageNames = array();
    protected $_pageLinks = array();

	protected $util;

    public function pathCrumbs($pageName = NULL, $pageLink = NULL) {
        if (!is_null($pageName)) {
            array_splice($this->_pageNames, 0, 0, $pageName);
            array_splice($this->_pageLinks, 0, 0, $pageLink);
        }
        return $this->pathString();
    }

    public function pathString() {
        $crumbString = "";
        if (count($this->_pageNames) == 1) return "";
        for ($i = 0; $i < count($this->_pageNames); $i++) {
            $link = $this->_pageLinks[$i];
            $name = $this->_pageNames[$i];
            if ($i > 0) $crumbString .= "&#187; ";
            if ($i == count($this->_pageNames)-1) $crumbString .= $name;
            else $crumbString .= "<a href=\"".$link."\">".$name."</a> ";
        }
        return $crumbString;
    }

    public function titleString() {
        $crumbString = "";
        for ($i = count($this->_pageNames)-1; $i >= 0; $i--) {
            $name = $this->_pageNames[$i];
            $crumbString .= $name;
            $crumbString .= " - ";
        }
        return preg_replace("/- <span.*?<\/span>/", "", $crumbString);
    }
}
