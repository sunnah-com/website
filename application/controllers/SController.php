<?php
/**
 * SController is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

namespace app\controllers;

use \yii\web\Controller;
use app\modules\front\models\Util;

class SController extends Controller
{

	public function __construct($id, $module = NULL, $config = NULL) {
		parent::__construct($id, $module, $config);
		$this->util = new Util();
		$this->_viewVars = new \StdClass();
	}

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	protected $_viewVars;
	protected $_pageType;
	protected $_errorMsg;

	protected $_titleOverrideCrumbs = false;
	protected $_pageNames = array();
    protected $_pageLinks = array();
    protected $_titleSections = array();

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
            if ($i > 0) $crumbString .= "<i class=icn-right></i>";
            if ($i == count($this->_pageNames)-1) $crumbString .= "<span class=currentpage>".$name."</span>";
            else $crumbString .= "<a href=\"".$link."\">".$name."</a> ";
        }
        return $crumbString;
    }

    public function prependToPageTitle($section) {
        $this->_titleOverrideCrumbs = true;
        array_splice($this->_titleSections, 0, 0, $section);
        return $this->titleString();
    }

    public function titleString() {
        $src_array = $this->_pageNames;
        if ($this->_titleOverrideCrumbs) {
            $src_array = $this->_titleSections;
        }

        $title = "";
        for ($i = count($src_array) - 1; $i >= 0; $i--) {
            $name = $src_array[$i];
            $title .= $name;
            $title .= " - ";
        }
        $title = preg_replace("/- <span.*?<\/span>/", "", $title);
        return strip_tags($title);
    }

    public function auto_version($filename) {
        if (YII_DEBUG || strpos($filename, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $filename))
            return $filename;

        $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $filename);
        return $filename . "?ver=" . $mtime ;
    }
}
