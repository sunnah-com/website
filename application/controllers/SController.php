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

    public function auto_version($filename) {
        if (strpos($filename, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $filename))
            return $filename;

        $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $filename);
        return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $filename);
    }
}
