<?php
/**
 * XFoundation class file.
 *
 * Inserts client scripts needed for Foundation 5 CSS Framework.
 *
 * The following shows how to use Foundation component:
 *
 * <pre>
 * 'preload'=>array(
 *     'foundation'
 * ),
 * 'components'=>array(
 *     'foundation'=>array(
 *          'class'=>'ext.components.foundation.XFoundation',
 *          'maxWidth'=>'75em'
 *     ),
 * )
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0
 */
class XFoundation extends CApplicationComponent
{
	/**
	 * @var boolean whether to register the Foundation core CSS (foundation.css).
	 * Defaults to true.
	 */
	public $coreCss=true;
	/**
	 * @var boolean whether to register jQuery and the Foundation JavaScript.
	 * Defaults to true.
	 */
	public $enableJs=true;
	/**
	 * @var boolean whether to register jquery.stickyFooter.js for sticky footer.
	 * Defaults to false.
	 */
	public $stickyFooter=false;
	/**
	 * @var string grid max width. If not set, default max-width defined in foundation.css is used.
	 */
	public $maxWidth;

	protected $_assetsUrl;

	/**
	 * Initializes the component.
	 */
	public function init()
	{
		$cs=Yii::app()->clientScript;
		$cs->registerCssFile($this->getAssetsUrl().'/css/normalize.css');

		if($this->coreCss)
			$cs->registerCssFile($this->getAssetsUrl().'/css/foundation.css');

		if($this->maxWidth)
			$cs->registerCss(__CLASS__, ".row {max-width: $this->maxWidth;}", "screen", CClientScript::POS_HEAD);

		if($this->enableJs)
			$this->registerJs();
	}

	/**
	 * Registers the javascripts
	 */
	public function registerJs()
	{
		$cs=Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');

		if($this->stickyFooter)
			$cs->registerScriptFile($this->getAssetsUrl().'/js/jquery.stickyFooter.js', CClientScript::POS_END);

		$cs->registerScriptFile($this->getAssetsUrl().'/js/modernizr.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($this->getAssetsUrl().'/js/foundation.min.js', CClientScript::POS_END);
		$cs->registerScriptFile($this->getAssetsUrl().'/js/foundation.dropdown.js', CClientScript::POS_END);
		$cs->registerScript(__CLASS__, "$(document).foundation();", CClientScript::POS_END);
	}

	/**
	 * Publishes assets and returns the URL to the published assets folder.
	 * @return string the URL
	 */
	protected function getAssetsUrl()
	{
		if($this->_assetsUrl==null)
		{
			$assetsPath=dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
			$this->_assetsUrl=Yii::app()->assetManager->publish($assetsPath, false, -1, YII_DEBUG);
		}
		return $this->_assetsUrl;
	}
}
