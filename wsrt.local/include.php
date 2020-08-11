<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\ModuleManager;
use function check_bitrix_sessid;
use Bitrix\Main\Web\Json;    // Json::encode($selectColumns)
// TABLE_LOADER_WAIT: "<?= \CUtil::jsEscape(Loc::getMessage('LANDING_LOADER_WAIT'));?\>"    

$application = Application::getInstance();
$modulePath = getLocalPath('modules/wsrt.local');
$libPath = $application->getDocumentRoot() . $modulePath . '/lib';
$pathJS = '/local/modules/wsrt.local/js';    
$pathCSS = '/local/modules/wsrt.local/css';

$jsConfig = array(
	'thiz' => array(
		'js' => array(
			$pathJS . '/script_module.js',
            ),
		'css' => array(
			$pathCSS . '/style_module.css',
          )
    ),
    'table' => array(
		'js' => array(
			$pathJS . '/tabulatorcore.min.js',
			$pathJS . '/tabulator.min.js'
            ),
		'css' => array(
			$pathCSS . '/tabulatorsemanticui.min.css',
          )
    ),
    'xlsx' => array(
		'js' => array(
			$pathJS . '/xlsx.core.min.js',
            $pathJS . '/xls.core.min.js'
            ),
    ));
    

    
$iterator = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator($libPath)
);

$classes = [];
foreach ($iterator as $file) {
  if ($file->isDir())
    continue;

  $pathName = $file->getPathname();

  $basePath = str_replace($libPath, '', $pathName);
  $name = str_replace('.php', '', $basePath);
  $name = str_replace('/', '\\', $name);
  $path = 'lib' . $basePath;
  $classes[$name] = $path;
}

foreach ($jsConfig as $code => $ext)
{
	\CJSCore::RegisterExt($code, $ext);
}
// var_dump(CJSCore::IsExtRegistered('landing_master'));
/*
---------

	\Bitrix\Main\Loader::includeModule("wsrt.local");
	// \CJSCore::init(array('landing_master'));	
	\CJSCore::init('landing_master');
	var_dump(CJSCore::IsExtRegistered('landing_master'));


$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$curUrl = $request->getRequestUri();

$ret=new \LocHandle(['1'=>2],__FILE__.':'.__LINE__);


*/
global $APPLICATION;
$APPLICATION->AddHeadScript('/local/modules/wsrt.local/js/main.js');


// print_r('module cs is run..:'.__FILE__.' : '.__LINE__);
Loader::registerAutoLoadClasses('exampletable', $classes);
// Loader::registerAutoLoadClasses('phpspreadsheet', $classes);

CBitrixComponent::includeComponentClass('bitrix:catalog.section');
echo CBitrixComponent::includeComponentClass('bitrix:iblock.element.add.form');
// var_dump(CatalogSectionComponent);

class LocFaqHelper
{
	static $MODULE_ID = "123.abc";
    public static function getTableName()
    {
        return '--- table';
    }
}


class LocHtmlcustom
{
	
	public function appendScript($sfile='')
	{
		if(empty($sfile))return "";
		$dirjs=dirname(__FILE__).'/js';
		echo "<script>".file_get_contents($dirjs.'/'.$sfile)."</script>";
		return "";
	}
}
// echo \LocHtmlcustom::dirjs
class LocTabAddXls extends CBitrixComponent
{
    // use LocExecTrait;
	public $isdebug;
	public $users;
	
    
    public function __construct(CBitrixComponent $component = null,$placefile='')
    {
        parent::__construct($component);
        global $APPLICATION, $USER, $arParams,$GLOBALS;
		
		$this->isdebug=True;
		// $this->isdebug=False;
        $this->errors = new ErrorCollection();
		$this->users=self::chekUsers();
		// $this->includeComponentTemplate('test');
        $GLOBALS['LOG']='extends cs is run..:'.__FILE__.' : '.__LINE__.' from..:'.$placefile;
        $GLOBALS['CMP']=$this;
		

        $arCMPDUMP=[];
        if(is_object($component) && ($component instanceof cbitrixcomponent))
                {
                  $arCMPDUMP=['__name' => $this->__name,
                    '__relativePath' => $this->__relativePath,
                    '__path' => $this->__path,
                    '__templateName' => $this->__templateName,
                    '__templatePage' => $this->__templatePage,
                    // '__template' => $this->__template,
                    '__component_epilog' => $this->__component_epilog,
                    'arParams' => $this->arParams,
                    'arResult' => $this->arResult,
                    'arResultCacheKeys' => $this->arResultCacheKeys,
                    // '__parent' => $this->__parent,
                    '__bInited' => $this->__bInited,
                    '__arIncludeAreaIcons' => $this->__arIncludeAreaIcons,
                    '__NavNum' => $this->__NavNum,
                    '__cache' => $this->__cache,
                    '__cacheID' => $this->__cacheID,
                    '__cachePath' => $this->__cachePath,
                    '__children_css' => $this->__children_css,
                    '__children_js' => $this->__children_js,
                    '__children_epilogs' => $this->__children_epilogs,
                    '__children_frames' => $this->__children_frames,
                    '__view' => $this->__view,
                    '__currentCounter' => $this->__currentCounter,
                    '__currentCounters' => $this->__currentCounters,
                    '__editButtons' => $this->__editButtons,
                    'classOfComponent' => $this->classOfComponent];
                }      
        // print_r('extends cs is run..:'.__FILE__.' : '.__LINE__);
          // if($this->isdebug)echo '<script> console.log('.json_encode($arCMPDUMP).');</script>';
			
		 // print_r($this->isdebug);
			
      
    }
    
    public function dumpj(){
      
      // return '<script> console.log('.(json_encode(\LocExec::objectToArray(var_export($GLOBALS['CMP'])))).');</script>';

        // echo "<pre>"; print_r ($arCMPDUMP); echo "</pre>";        
        // print_r(var_export($GLOBALS['CMP']));
      // $array = json_decode(json_encode($GLOBALS['CMP']), true);
      // $array=(array)(\LocExec::objectToArray(var_export($GLOBALS['CMP'])));
      // echo "<pre>"; print_r ((array)($GLOBALS['CMP'])); echo "</pre>";
      // echo "<pre>"; print_r ((json_encode(\LocExec::objectToArray(var_export($GLOBALS['CMP']))))); echo "</pre>";
      
      }
	  
	  
	 public function chekUsers(){
		 global $USER;
		 $user_id = $USER->GetID();
		// echo "<pre>usr:"; print_r ($user_id); echo "</pre>";


		$users = [$user_id];
				$rsUser = CUser::GetByID($user_id);
				if($arUser = $rsUser->Fetch()){
					if($arUser['UF_SCK']) {
						$newFilter = ["LOGIC"=>"OR"];
						$filter = array(
						   'UF_SCK' => $arUser['UF_SCK'],
						   'ACTIVE' => "Y",
						);
						$elementsResult = CUser::GetList(($by="ID"), ($order="DESC"), $filter);
						while($userRow = $elementsResult->Fetch()){
							if(!in_array($userRow["ID"],$users))$users[] = $userRow["ID"];
						}
					}
				}
			if($this->isdebug)echo '<script> console.log("users",'.json_encode($users).');</script>';		
		 return $users;
		 
		 }
  
}


class LocHandle extends CBitrixComponent {

 // die(__FILE__);
    // public function __construct()//
    public function __construct($component = null,$placefile='')
	{
		parent::__construct($component);
        global $APPLICATION, $USER, $arParams,$GLOBALS;
		

		$this->isdebug=True;
		// $this->isdebug=False;
        $this->errors = new ErrorCollection();
		// $this->includeComponentTemplate('test');
        $GLOBALS['LOG']='extends cs is run..:'.__FILE__.' : '.__LINE__.' from..:'.$placefile;
        $GLOBALS['CMP']=$this;
		

        $arCMPDUMP=[];
        if(is_object($component) && ($component instanceof cbitrixcomponent))
		{
				
		}elseif(is_array($component)){
			// if($this->isdebug)echo '<script> console.log("exec from '.$placefile.'",'.json_encode($component).');</script>';
		}
		
		// if($this->isdebug)return '<script> console.log("exec from: '.$placefile.'",'.json_encode($component).');</script>';
		
		
	}
    
    public function addResources(){
        \Bitrix\Main\Page\Asset::getInstance()->addJs($this->GetPath()."/script.js");
    }
    
}

class CatalogSectionLocal extends CatalogSectionComponent {

 // die(__FILE__);
    // public function __construct()//
    public function __construct($component = null,$placefile='')
	{
		parent::__construct($component);
        global $APPLICATION, $USER, $arParams,$GLOBALS;
        // $params = parent::onPrepareComponentParams($params);
        $GLOBALS['CMP']=$this; 
        $GLOBALS['LOG']='extends cs is run..:'.__FILE__.' : '.__LINE__.' from..:'.$placefile;
		// die(__FILE__.' : '.__LINE__);
        // print_r('extends cs is run..:'.__FILE__.' : '.__LINE__);
        // self::addResources();
	}
    
    public function addResources(){
        \Bitrix\Main\Page\Asset::getInstance()->addJs($this->GetPath()."/script.js");
    }
    
}

class CatalogSectionLocalFilesMaterialRequest extends CatalogSectionComponent {

		public $isdebug;
		public $users;
 // die(__FILE__);
    // public function __construct()//
    public function __construct($component = null,$placefile='')
	{
		parent::__construct($component);
        global $APPLICATION, $USER, $arParams,$GLOBALS;
        // $params = parent::onPrepareComponentParams($params);
		$this->isdebug=True;
		// $this->isdebug=False;
        $this->errors = new ErrorCollection();
		$this->users=self::chekUsers();
		// $this->includeComponentTemplate('test');
		// $this->setTemplateName('test');
        $GLOBALS['LOG']='extends cs is run..:'.__FILE__.' : '.__LINE__.' from..:'.$placefile;
        $GLOBALS['CMP']=$this;
		

        $arCMPDUMP=[];
        if(is_object($component) && ($component instanceof cbitrixcomponent))
                {
                  $arCMPDUMP=['__name' => $this->__name,
                    '__relativePath' => $this->__relativePath,
					'__abs_patch'=>$placefile,
                    '__path' => $this->__path,
                    '__templateName' => $this->__templateName,
                    '__templatePage' => $this->__templatePage,
                    // '__template' => $this->__template,
                    '__component_epilog' => $this->__component_epilog,
                    'arParams' => $this->arParams,
                    'arResult' => $this->arResult,
                    'arResultCacheKeys' => $this->arResultCacheKeys,
                    // '__parent' => $this->__parent,
                    '__bInited' => $this->__bInited,
                    '__arIncludeAreaIcons' => $this->__arIncludeAreaIcons,
                    '__NavNum' => $this->__NavNum,
                    '__cache' => $this->__cache,
                    '__cacheID' => $this->__cacheID,
                    '__cachePath' => $this->__cachePath,
                    '__children_css' => $this->__children_css,
                    '__children_js' => $this->__children_js,
                    '__children_epilogs' => $this->__children_epilogs,
                    '__children_frames' => $this->__children_frames,
                    '__view' => $this->__view,
                    '__currentCounter' => $this->__currentCounter,
                    '__currentCounters' => $this->__currentCounters,
                    '__editButtons' => $this->__editButtons,
                    'classOfComponent' => $this->classOfComponent];
                }      
        // print_r('extends cs is run..:'.__FILE__.' : '.__LINE__);
          // if($this->isdebug)echo '<script> console.log('.json_encode($arCMPDUMP).');</script>';
	}
    
	 public function chekUsers(){
		 global $USER;
		 $user_id = $USER->GetID();
		// echo "<pre>usr:"; print_r ($user_id); echo "</pre>";


		$users = [$user_id];
				$rsUser = CUser::GetByID($user_id);
				if($arUser = $rsUser->Fetch()){
					if($arUser['UF_SCK']) {
						$newFilter = ["LOGIC"=>"OR"];
						$filter = array(
						   'UF_SCK' => $arUser['UF_SCK'],
						   'ACTIVE' => "Y",
						);
						$elementsResult = CUser::GetList(($by="ID"), ($order="DESC"), $filter);
						while($userRow = $elementsResult->Fetch()){
							if(!in_array($userRow["ID"],$users))$users[] = $userRow["ID"];
						}
					}
				}
			// if($this->isdebug)echo '<script> console.log("users",'.json_encode($users).');</script>';		
		 return $users;
		 
		 }

    
}

// class PageZayavkiNaMaterialyTabZayavkiNaMaterialy
// class PageZayavkiNaMaterialyTabKonkursnajaDocumentacia
class PageZayavkiNaMaterialyTabZayavkiNaMaterialy extends CatalogSectionComponent {

		public $isdebug;
		public $users;
 // die(__FILE__);
    // public function __construct()//
    public function __construct($component = null,$placefile='')
	{
		parent::__construct($component);
        global $APPLICATION, $USER, $arParams,$GLOBALS;
        // $params = parent::onPrepareComponentParams($params);
		$this->isdebug=True;
		// $this->isdebug=False;
        $this->errors = new ErrorCollection();
		$this->users=self::chekUsers();
		// $this->arParams['PAGE_ELEMENT_COUNT']=11;
		// $this->arParams['~PAGE_ELEMENT_COUNT']=11;
		self::makeJstest();

		// $this->includeComponentTemplate('test');
        $GLOBALS['LOG']='extends cs is run..:'.__FILE__.' : '.__LINE__.' from..:'.$placefile;
        $GLOBALS['CMP']=$this;

		/*$APPLICATION->AddHeadString('<script type="text/javascript">var httwind_mtable=`<!-- Modal -->
                             <div class="modal fade" id="filecontainer" tabindex="-1" role="dialog" aria-labelledby="file_mtableLabel" aria-hidden="true">
                               <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                   <div class="modal-header">
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                     <h4 class="modal-title" id="file_mtableLabel">  </h4>
                                   </div>
                                   <div class="modal-body" id="getfilecontainer" style="overflow-x: scroll;">
                                      <div id="windmtable" class="tabulator" role="grid" tabulator-layout="fitData"><div class="tabulator-header" style="padding-right: 0px;"><div class="tabulator-headers" style="margin-left: 0px;"></div><div class="tabulator-frozen-rows-holder"></div></div><div class="tabulator-tableHolder" tabindex="0" style="height: 20px;"><div class="tabulator-table" style="min-width: 0px; min-height: 1px; visibility: hidden;"></div></div></div>
                                   </div>
                                </div>
                               </div>
                             </div>`;if(document.getElementById("filecontainer")===null){
									//$("body").append(httwind_mtable);document.body.appendChild
									document.children[0].innerHTML+=httwind_mtable;
							 };</script>');
							 
							 VM10992:90 Uncaught ReferenceError: jQuery is not defined in u:\wsrt\local\modules\wsrt.local\js\htmlcustomModal.j
							 
							 */
    
		

        $arCMPDUMP=[];
        if(is_object($component) && ($component instanceof cbitrixcomponent))
                {
                  $arCMPDUMP=['__name' => $this->__name,
                    '__relativePath' => $this->__relativePath,
					'__abs_patch'=>$placefile,
                    '__path' => $this->__path,
                    '__templateName' => $this->__templateName,
                    '__templatePage' => $this->__templatePage,
                    // '__template' => $this->__template,
                    '__component_epilog' => $this->__component_epilog,
                    'arParams' => $this->arParams,
                    // 'arResult' => $this->arResult,
                    'arResultCacheKeys' => $this->arResultCacheKeys,
                    // '__parent' => $this->__parent,
                    '__bInited' => $this->__bInited,
                    '__arIncludeAreaIcons' => $this->__arIncludeAreaIcons,
                    '__NavNum' => $this->__NavNum,
                    '__cache' => $this->__cache,
                    '__cacheID' => $this->__cacheID,
                    '__cachePath' => $this->__cachePath,
                    '__children_css' => $this->__children_css,
                    '__children_js' => $this->__children_js,
                    '__children_epilogs' => $this->__children_epilogs,
                    '__children_frames' => $this->__children_frames,
                    '__view' => $this->__view,
                    '__currentCounter' => $this->__currentCounter,
                    '__currentCounters' => $this->__currentCounters,
                    '__editButtons' => $this->__editButtons,
                    'classOfComponent' => $this->classOfComponent];
                }      
        // print_r('extends cs is run..:'.__FILE__.' : '.__LINE__);
          // if($this->isdebug)echo '<script>var runaddheaad; console.log(('.json_encode($arCMPDUMP).'));</script>';
				
				$items = array_map(function($res) {
					$from_multi=$res["PROPERTIES"]["VIEWS"]["~VALUE"];
					return array(
						"ID"=>$res['ID'],
						"CREATED_BY"=>$res['CREATED_BY'],
						"PROPERTY_ADD_DATE_VALUE"=>$res['PROPERTY_ADD_DATE_VALUE'],
						"SCK"=>$res["PROPERTIES"]["SCK"]["VALUE"],
						"COMPETENCE"=>$res["PROPERTIES"]["COMPETENCE"]["VALUE"],
						"EXPEND_ITEM"=>$res["PROPERTIES"]["EXPEND_ITEM"]["VALUE"],
						"VIEWS"=>end($from_multi),
						"STATUS"=>$res["PROPERTIES"]["STATUS"]["VALUE_ENUM"],
						"EXTEND"=>'<a href="javascript:void(0)" data-toggle="nomodalbutspoler" onclick="viewContaintDoc('.$res['ID'].',window.pageYOffset)" id="view'.$res['ID'].'" data-status="'.$res["PROPERTIES"]["STATUS"]["VALUE_ENUM"].'" data-target="#viewModal" data-id="'.$res['ID'].'" title="Содержимое заявки на материалы"><i class="glyphicon glyphicon-eye-open"></i></a><a href="request_new.php?edit=Y&amp;CODE='.$res['ID'].'" title="редактировать"><i class="glyphicon glyphicon-pencil"></i></a>',
					);
				}, $this->arResult["ITEMS"]);
				
				
			echo '<script> var res={}; res["data"]='.json_encode($items).';
			res["columns"]=[
				{title:"ID", field:"ID", width:20, hozAlign:"center"},
				{title:"Автор заявки", field:"CREATED_BY", widthGrow:1, editor:"input"},
				{title:"Дата подачи", field:"PROPERTY_ADD_DATE_VALUE", widthGrow:1, editor:"input"},
				{title:"Образовательное учреждение", field:"SCK", widthGrow:2, editor:"input"},
				{title:"Компетенция", field:"COMPETENCE", widthGrow:1, editor:"input"},
				{title:"Статья расходов", field:"EXPEND_ITEM", widthGrow:1, editor:"input"},
				{title:"Статус заявки", field:"STATUS", widthGrow:1, editor:"input"},
				{title:"Просмотры", field:"VIEWS", widthGrow:1, editor:"input"},
				{title:"Example", field:"EXTEND", formatter:"html"}
			]; 	
			</script><style>.tabulator .tabulator-header .tabulator-col .tabulator-col-content .tabulator-col-title{white-space: break-spaces!important;}.tabulator .tabulator-header .tabulator-col[tabulator-field="name"]{}</style>';
			
	}

	public function makeJstest(){
		
		global $APPLICATION;
		$arJSConstants = [
			["title" => "№", "field" => "docnum", "width" => 20, "hozAlign" => "center"],
			["title" => "Наименование товара", "field" => "NAME", "widthGrow" => 2, "editor" => "input"],
			["title" => "Ед. изм.", "field" => "mean", "width" => 20],
			["title" => "Кол-во", "field" => "count", "width" => 20, "editor" => "input"],
			["title" => "Упак", "field" => "count", "width" => 20, "editor" => "input"],
			["title" => "Ссылка на сайт продавца", "field" => "links", "widthGrow" => 2, "editor" => "input"],
			["title" => "Желаемая дата поставки", "field" => "", "widthGrow" => 1, "editor" => "input"],
			["title" => "Адрес поставки", "field" => "street", "widthGrow" => 2, "editor" => "input"],
			["title" => "Ориентировочная стоимость за ед.", "field" => "costbymean", "width" => 40, "editor" => "input"],
			["title" => "Стоимость за ед.", "field" => "costby", "width" => 30, "editor" => "input"],
			["title" => "Сумма", "field" => "", "width" => 30, "editor" => "input"],
			["title" => "Example", "field" => "EXTEND", "formatter" => "html"]
		];


		$arJSConstants1 = array(
			'BX_PERSONAL_ROOT' => BX_PERSONAL_ROOT,
			'SITE_ID' => SITE_ID,
			'SITE_DIR' => SITE_DIR,
			'SITE_CHARSET' => SITE_CHARSET,
			'SITE_TEMPLATE_ID' => SITE_TEMPLATE_ID,
			'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH,
			'MODULE_DIR' => BX_PERSONAL_ROOT.'/modules/intec.startshop'
		);

		$APPLICATION->AddHeadString('<script type="text/javascript">var StartshopConstants = '.CUtil::PhpToJSObject($arJSConstants).'; </script>');
		unset($arJSConstants);
		
		
		}
		
	 public function chekUsers(){
		 global $USER;
		 $user_id = $USER->GetID();
		// echo "<pre>usr:"; print_r ($user_id); echo "</pre>";


		$users = [$user_id];
				$rsUser = CUser::GetByID($user_id);
				if($arUser = $rsUser->Fetch()){
					if($arUser['UF_SCK']) {
						$newFilter = ["LOGIC"=>"OR"];
						$filter = array(
						   'UF_SCK' => $arUser['UF_SCK'],
						   'ACTIVE' => "Y",
						);
						$elementsResult = CUser::GetList(($by="ID"), ($order="DESC"), $filter);
						while($userRow = $elementsResult->Fetch()){
							if(!in_array($userRow["ID"],$users))$users[] = $userRow["ID"];
						}
					}
				}
			if($this->isdebug)echo '<script> console.log("users",'.json_encode($users).');</script>';		
		 return $users;
		 
		 }

    
}

class PageZayavkiNaMaterialyTabKonkursnajaDocumentacia extends CatalogSectionComponent {

		public $isdebug;
		public $users;
 // die(__FILE__);
    // public function __construct()//
    public function __construct($component = null,$placefile='')
	{
		parent::__construct($component);
        global $APPLICATION, $USER, $arParams,$GLOBALS;
        // $params = parent::onPrepareComponentParams($params);
		$this->isdebug=True;
		// $this->isdebug=False;
        $this->errors = new ErrorCollection();
		$this->users=self::chekUsers();
		// $this->includeComponentTemplate('test');
        $GLOBALS['LOG']='extends cs is run..:'.__FILE__.' : '.__LINE__.' from..:'.$placefile;
        $GLOBALS['CMP']=$this;
		

        $arCMPDUMP=[];
        if(is_object($component) && ($component instanceof cbitrixcomponent))
                {
                  $arCMPDUMP=['__name' => $this->__name,
                    '__relativePath' => $this->__relativePath,
					'__abs_patch'=>$placefile,
                    '__path' => $this->__path,
                    '__templateName' => $this->__templateName,
                    '__templatePage' => $this->__templatePage,
                    // '__template' => $this->__template,
                    '__component_epilog' => $this->__component_epilog,
                    'arParams' => $this->arParams,
                    'arResult' => $this->arResult,
                    'arResultCacheKeys' => $this->arResultCacheKeys,
                    // '__parent' => $this->__parent,
                    '__bInited' => $this->__bInited,
                    '__arIncludeAreaIcons' => $this->__arIncludeAreaIcons,
                    '__NavNum' => $this->__NavNum,
                    '__cache' => $this->__cache,
                    '__cacheID' => $this->__cacheID,
                    '__cachePath' => $this->__cachePath,
                    '__children_css' => $this->__children_css,
                    '__children_js' => $this->__children_js,
                    '__children_epilogs' => $this->__children_epilogs,
                    '__children_frames' => $this->__children_frames,
                    '__view' => $this->__view,
                    '__currentCounter' => $this->__currentCounter,
                    '__currentCounters' => $this->__currentCounters,
                    '__editButtons' => $this->__editButtons,
                    'classOfComponent' => $this->classOfComponent];
                }

			/*    global $APPLICATION;
			$arJSConstants = array(
				'BX_PERSONAL_ROOT' => BX_PERSONAL_ROOT,
				'SITE_ID' => SITE_ID,
				'SITE_DIR' => SITE_DIR,
				'SITE_CHARSET' => SITE_CHARSET,
				'SITE_TEMPLATE_ID' => SITE_TEMPLATE_ID,
				'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH,
				'MODULE_DIR' => BX_PERSONAL_ROOT.'/modules/intec.startshop'
			);
			$APPLICATION->AddHeadString('<script type="text/javascript">var StartshopConstants = '.CUtil::PhpToJSObject($arJSConstants).'; if (typeof Startshop != "undefined") { Startshop.Constants = StartshopConstants; StartshopConstants = undefined; }</script>');
			unset($arJSConstants);*/
				
				
        // print_r('extends cs is run..:'.__FILE__.' : '.__LINE__);
          // if($this->isdebug)echo '<script> console.log(('.json_encode($arCMPDUMP).'["arResult"]["ITEMS"]));</script>';
				
			$items = array_map(function($res) {
					return array(
						// "ID"=>$res['ID'],
						// "CREATED_BY"=>$res['CREATED_BY'],
						// "PROPERTY_ADD_DATE_VALUE"=>$res['PROPERTY_ADD_DATE_VALUE'],
						// "SCK"=>$res["PROPERTIES"]["SCK"]["VALUE"],
						// "COMPETENCE"=>$res["PROPERTIES"]["COMPETENCE"]["VALUE"],
						// "EXPEND_ITEM"=>$res["PROPERTIES"]["EXPEND_ITEM"]["VALUE"],
						// "VIEWS"=>$res["PROPERTIES"]["VIEWS"]["VALUE"]
					"ID"=>  $res["ID"],
					"DATE_ACTIVE_FROM"=>  $res["DATE_ACTIVE_FROM"],
					"CREATED_BY"=>  $res["CREATED_BY"],
					"COMPETENCE"=>  $res["PROPERTIES"]["COMPETENCE"]["VALUE"],
					"EXPEND_ITEM"=>  $res["PROPERTIES"]["EXPEND_ITEM"]["VALUE"],
					"COMPETENCE_URL"=>  $res["DISPLAY_PROPERTIES"]['COMPETENCE']['DISPLAY_VALUE'],
					"EXTEND"=> '<a href="edit_file.php?edit=Y&amp;CODE='.$res["ID"].'" title="редактировать"><i class="glyphicon glyphicon-pencil"></i></a>',
					);
				}, $this->arResult["ITEMS"]);
					
			// ID Дата изменения Автор Компетенция Статьи расходов Правка	
		// if($this->isdebug)
		echo '<script> var reszf={}; reszf["data"]='.json_encode($items).';
			reszf["columns"]=[
				{title:"ID", field:"ID", width:70, hozAlign:"left"},
				{title:"Дата изменения", field:"DATE_ACTIVE_FROM", widthGrow:1, editor:"input"},
				{title:"Автор", field:"CREATED_BY", widthGrow:1, editor:"input"},
				{title:"Компетенция", field:"COMPETENCE", widthGrow:1, editor:"input"},
				{title:"Статья расходов", field:"EXPEND_ITEM", widthGrow:1, editor:"input"},
				// {title:"Правка", field:"COMPETENCE_URL", widthGrow:1, editor:"input"},
				{title:"Example", field:"EXTEND", formatter:"html"}
			]; 	
			</script><style>.tabulator .tabulator-header .tabulator-col .tabulator-col-content .tabulator-col-title{white-space: break-spaces!important;}.tabulator .tabulator-header .tabulator-col[tabulator-field="name"]{}</style>';		
	}
    
	 public function chekUsers(){
		 global $USER;
		 $user_id = $USER->GetID();
		// echo "<pre>usr:"; print_r ($user_id); echo "</pre>";


		$users = [$user_id];
				$rsUser = CUser::GetByID($user_id);
				if($arUser = $rsUser->Fetch()){
					if($arUser['UF_SCK']) {
						$newFilter = ["LOGIC"=>"OR"];
						$filter = array(
						   'UF_SCK' => $arUser['UF_SCK'],
						   'ACTIVE' => "Y",
						);
						$elementsResult = CUser::GetList(($by="ID"), ($order="DESC"), $filter);
						while($userRow = $elementsResult->Fetch()){
							if(!in_array($userRow["ID"],$users))$users[] = $userRow["ID"];
						}
					}
				}
			if($this->isdebug)echo '<script> console.log("users tableZMCD",'.json_encode($users).');</script>';		
		 return $users;
		 
		 }

    
}


class LocExec
{

  
    public static function getUserInstance()
	{
		return $GLOBALS['USER'];
	}
  
	public static function isAdmin()
	{
		$user = self::getUserInstance();

		if (ModuleManager::isModuleInstalled('bitrix24'))
		{
			return $user->canDoOperation('bitrix24_config');
		}
		else
		{
			return $user->isAdmin();
		}
	}  
  
  
    public static function getUserId()
	{
		$user = self::getUserInstance();
		if ($user instanceof \CUser)
		{
			return $user->getId();
		}
		return 0;
	}
  
    public static function getDocRoot()
	{
		static $docRoot = null;

		if ($docRoot === null)
		{
			$context = Application::getInstance()->getContext();
			$server = $context->getServer();
			$docRoot = $server->getDocumentRoot();
		}

		return $docRoot;
	}

	/**
	 * Save picture to db.
	 * @param mixed $file File array or path to file.
	 * @param string $ext File extension (if can't detected by file name).
	 * @param array $params Some file params.
	 * @return array|false Local file array or false on error.
	 */
	public static function savePicture($file, $ext = false, $params = array())
	{
		// local file
		if (!is_array($file) && substr($file, 0, 1) == '/')
		{
			$file = \CFile::makeFileArray($file);
		}
		// url of picture
		else if (!is_array($file))
		{
			$httpClient = new \Bitrix\Main\Web\HttpClient();
			$httpClient->setTimeout(5);
			$httpClient->setStreamTimeout(5);
			$urlComponents = parse_url($file);
			$dimensionDelta = 10;// delta for resize

			// detect tmp file name
			if ($urlComponents && $urlComponents['path'] != '')
			{
				$tempPath = \CFile::getTempName('', bx_basename(urldecode($urlComponents['path'])));
			}
			else
			{
				$tempPath = \CFile::getTempName('', bx_basename(urldecode($file)));
			}
			if ($ext !== false && in_array($ext, explode(',', \CFile::getImageExtensions())))
			{
				if (substr($tempPath, -3) != $ext)
				{
					$tempPath = $tempPath . '.' . $ext;
				}
			}

			// download and save
			if ($httpClient->download($file, $tempPath))
			{
				$fileName = $httpClient->getHeaders()->getFilename();
				$file = \CFile::makeFileArray($tempPath);
				if ($file && $fileName)
				{
					$file['name'] = $fileName;
				}
			}
		}

		// base64
		elseif (
			is_array($file) &&
			isset($file[0]) &&
			isset($file[1])
		)
		{
			$fileParts = explode('.', $file[0]);
			$ext = array_pop($fileParts);
			$tempPath = \CFile::getTempName(
				'',
				\CUtil::translit(
					implode('', $fileParts),
					'ru'
				) . '.' . $ext
			);
			$fileIO = new \Bitrix\Main\IO\File(
				$tempPath
			);
			$fileIO->putContents(
				base64_decode($file[1])
			);
			$file = \CFile::makeFileArray($tempPath);
		}

		// post array or file from prev. steps
		if (\CFile::checkImageFile($file, 0, 0, 0, array('IMAGE')) === null)
		{
			// resize if need
			if (
				isset($params['width']) &&
				isset($params['height'])
			)
			{
				$params['width'] += intval($params['width'] / 100 * $dimensionDelta);
				$params['height'] += intval($params['height'] / 100 * $dimensionDelta);
				\CFile::resizeImage(
					$file,
					$params,
					isset($params['resize_type'])
					? intval($params['resize_type'])
					: BX_RESIZE_IMAGE_PROPORTIONAL);
			}
			// save
			$module = 'landing';
			$file['MODULE_ID'] = $module;
			$file = \CFile::saveFile($file, $module);
			if ($file)
			{
				$file = \CFile::getFileArray($file);
			}
			if ($file)
			{
				return $file;
			}
		}

		return false;
	}
  
  
  	public static function isStoreEnabled()
	{
		return ModuleManager::isModuleInstalled('sale') &&
			   ModuleManager::isModuleInstalled('catalog') &&
			   ModuleManager::isModuleInstalled('iblock');
	}
  
  	public static function isstring($str)
	{
		return $str;
	}
      
    
  	public static function sanitize($value, &$bad = false, $splitter = ' ')
	{
		static $sanitizer = null;

		if (!is_bool($bad))
		{
			$bad = false;
		}

		if ($sanitizer === null)
		{
			$sanitizer = false;
			if (Loader::includeModule('security'))
			{
				$sanitizer = new \Bitrix\Security\Filter\Auditor\Xss(
					$splitter
				);
			}
		}

		if ($sanitizer)
		{
			// bad value exists
			if ($sanitizer->process($value))
			{
				$bad = true;
				$value = $sanitizer->getFilteredValue();
			}
		}

		return $value;
	}
 
    public static function objectToArray($data) 
    {
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = self::objectToArray($value);
            }
            return $result;
        }
        return $data;
    }
    
    /**
    Преобразовывает в JSON все пары key => value var_dump(json_decode(true_json($b_json)));
    Не нужно придумывать свои названия. Нет такого "Bitrix JSON".

    Функция переводит любой объект в строку. https://www.php.net/manual/ru/function.serialize.php

    И наоборот. https://www.php.net/manual/ru/function.unserialize.php

    $str = 'a:7:{i:0;a:13:{s:2:"ID"...';
    $arr = unserialize($str); // Получили массив с данными (в данном случае)
    json_encode($arr); // Преобразовали его в JSON
    **/
    public static function json_parse($json) {// invalid json parser
        $normal_json = "";
        $json = str_split($json);// str (invalid json) >>> array
        $arr_len = $json[0];
        $key = 0;

        while($json[$key] != "{"){
            $key++;
        };
        $key++;

        for($key = $key; $key < count($json) - 1; $key++) {
            $let = $json[$key];
            if($let == "a" && $json[$key+1] == ":"){// aray lengh

                $key = $key + 2;
                $value = "";

                while($json[$key] != ":"){
                        $value = $value.$json[$key];
                        $key++;
                }

            } elseif ($let == "s" && $json[$key+1] == ":") {// string lengh
                $key = $key + 2;
                $value = "";

                while($json[$key] != ":"){
                        $value = $value.$json[$key];
                        $key++;
                }

            } elseif ($let == "i" && $json[$key+1] == ":") {// i: >>> id array
                $key = $key + 2;
                $value = "";

                while($json[$key] != ";"){
                        $value = $value.$json[$key];
                        $key++;
                }
                if ($value < $arr_len) {

                } else {
                    $key = $key - 2;
                }
            } elseif ($let == "}" || $let == "{") {// {}
                $normal_json = $normal_json.$let;

            } elseif ($let == ";" ) {// ; >>> ,
                $normal_json = $normal_json.", ";

            } elseif ($let == '"' ) {// "key":"value"
                $key++;
                $value = "";
                    while ($json[$key] != '"') {
                        $value = $value.$json[$key];

                        $key++;
                    }
                    if($value == "SORT") {// skip
                        $key++;
                        continue;
                    } elseif ($value == "DATE_FROM_TODAY" || $value == "DATE_TO_TODAY") {// skip
                        $key = $key + 5;
                        continue;
                    }

                    $value1 = $value.'" : "';
                    $value = "";

                    $key++;
                    while ($json[$key] != '"') $key++;
                    $key++;

                    while ($json[$key] != '"') {
                        $value = $value. $json[$key];
                        $key++;
                    };

                    if ($value == "busy") $key++;
                    $value = $value1.$value;
                $normal_json = $normal_json.'"'.$value.'"';
            }
        };

            return $normal_json;
    }


    public static function  true_json($b_json) {
        $json_norm = str_split(json_parse($b_json));
        $json = "";


        for($key = 0; $key < count($json_norm); $key++) {
            $let = $json_norm[$key];

            if ($let == "}" && $json_norm[$key + 1] == "{") {
                $json = $json."},{";
                $key++;
            }
            else $json = $json.$let;
        }

        return "[".$json."]";
    }

    
}


class MPrep
{
		public $isdebug;
		public $prep69;
		public $prep73;
		public $way;
		public $road;
		public $leplace;
		public $itwhich;
	
		function __construct()
		{
			// global $APPLICATION, $USER, $arParams,$GLOBALS;
			global $DB;
			$this->isdebug=True;
			
			self::setInits();
			// $this->isdebug=False;
			return;
		}	
		
		function setInits(){
			if(!isset($DB)){global $DB;}
			$s="SELECT
			  ID,NAME
			FROM b_iblock_element WHERE IBLOCK_ID=3";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$this->prep69=[];
			while($res = $ob ->fetch()){
				$this->prep69[$res['ID']]=$res['NAME'];
				
				}
			$this->road=$this->prep69;
				
			$s="SELECT ID,VALUE FROM b_iblock_property_enum WHERE PROPERTY_ID=69 ORDER BY ID";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$this->prep73=[];
			while($res = $ob ->fetch()){
				$this->prep73[$res['ID']]=$res['VALUE'];
				
				}
			$this->way=$this->prep73;	

			$s="SELECT  bie.ID,bie.NAME FROM b_iblock_element bie WHERE IBLOCK_ID=2";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$this->leplace=[];
			while($res = $ob ->fetch()){
				$this->leplace[$res['ID']]=$res['NAME'];
				}

			$s="SELECT 
			  ID,VALUE
			  -- ,XML_ID -- ACCEPT NEW REFUSE SEND
			FROM b_iblock_property_enum 
			  WHERE PROPERTY_ID=75";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$this->itwhich=[];
			while($res = $ob ->fetch()){
				$this->itwhich[$res['ID']]=$res['VALUE'];
				}
				
				
			}
			
			
		
		function isDocEnableFor($id,$iduser=0){
			/*
			it user  in this.group.
			if this.user in [this.group]
				return true
			*/
			if(!isset($DB)){global $DB;}
			$s="SELECT
			  CREATED_BY,
			  MODIFIED_BY
			FROM b_iblock_element WHERE
			 IBLOCK_ID=9 
			AND ID='$id'";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$ret=[];
			if($res = $ob ->fetch()){
				$ret[]=$res['CREATED_BY'];
				$ret[]=$res['MODIFIED_BY'];
				}
			if (\LocExec::isAdmin() or in_array(\LocExec::getUserId(),$ret))
			{
				return True;
			}
			else
			{
				return False;
			}
			}

		function viewListDocByUser($iduser=''){
			if(!isset($DB)){global $DB;}
			$iduser=self::getUsersIDFromGroupByThisId($iduser);
			$s="SELECT 
				bie.ID,
				-- biep.IBLOCK_ELEMENT_ID ID,
				-- biep.IBLOCK_PROPERTY_ID,
				-- biep.VALUE,
				biep73.VALUE way,
				-- biep73.IBLOCK_PROPERTY_ID,
				biep69.VALUE road,
				biep68.VALUE leplace,
				biep75.VALUE itwhich,
				bie.IBLOCK_ID,
				bie.DATE_CREATE,
				bie.NAME,
				bie.CREATED_BY
				FROM b_iblock_element bie
				-- FROM b_iblock_element_property biep 
				-- LEFT JOIN b_iblock_element_property biep ON bie.ID=biep.IBLOCK_ELEMENT_ID
				  LEFT JOIN b_iblock_element_property biep73 ON bie.ID=biep73.IBLOCK_ELEMENT_ID
				  LEFT JOIN b_iblock_element_property biep69 ON bie.ID=biep69.IBLOCK_ELEMENT_ID
				LEFT JOIN b_iblock_element_property biep68 ON bie.ID=biep68.IBLOCK_ELEMENT_ID -- leplace
				LEFT JOIN b_iblock_element_property biep75 ON bie.ID=biep75.IBLOCK_ELEMENT_ID -- newor
				WHERE 
				(biep73.IBLOCK_PROPERTY_ID=73 AND biep69.IBLOCK_PROPERTY_ID=69 AND biep68.IBLOCK_PROPERTY_ID=68 AND biep75.IBLOCK_PROPERTY_ID=75)
				AND bie.CREATED_BY IN ('".implode("'",$iduser)."')
				-- biep.IBLOCK_PROPERTY_ID=70 AND 
				-- AND biep.IBLOCK_ELEMENT_ID IN (54124)
				ORDER BY bie.DATE_CREATE DESC";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$ret=[];
			while($res = $ob ->fetch()){
				$ret[]=$res;
				}
			return $ret;
				
			}

		function getUsersIDFromGroupByThisId($userId){
			return [$userId];
			}	
			
			
		function chek($pid='',$val='',$eid='')
		{
			if(!isset($DB)){global $DB;}
			$s="SELECT 
				  count(ID) cnt
				FROM b_iblock_element_property 
				  WHERE IBLOCK_PROPERTY_ID='$pid' ";
				!empty($val)&&$s.="AND VALUE='$val'";
				!empty($eid)&&$s.="AND IBLOCK_ELEMENT_ID='$eid'";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$ret=0;
			if($res = $ob ->fetch()){
				(int)$res['cnt']>0&&$ret=$res['cnt'];
				}
			return $ret;
		}
		
		function exist($id='',$val='')
		{
			return $id;
		}

		function listFilesFromFromKonkDoc($idKdoc=''){
			if(!isset($DB)){global $DB;}
			$s="SELECT 
			biep80.VALUE as ID
			,bie.ID as IDR
			,bie.NAME as NAME
			,bie.IBLOCK_ID
			,biep76.VALUE fileID
			,bfe.ORIGINAL_NAME
			,bfe.SUBDIR
			,bfe.FILE_NAME
			,bfe.CONTENT_TYPE
			FROM b_iblock_element bie  
			LEFT JOIN b_iblock_element_property biep80 ON bie.ID=biep80.IBLOCK_ELEMENT_ID -- Связи файлов withIB11
			LEFT JOIN b_iblock_element_property biep76 ON bie.ID=biep76.IBLOCK_ELEMENT_ID -- GOOD_KP file is
			LEFT JOIN b_file bfe ON bfe.ID=biep76.VALUE
			WHERE 
			-- biep80.IBLOCK_PROPERTY_ID=80
			-- AND biep80.VALUE=49411";
				if (is_array($idKdoc))
						{
							$s.="biep80.VALUE IN ('".implode("'",$idKdoc)."')";
						}
						else
						{
							$s.="biep80.VALUE='$idKdoc'";
						}

			  $s.=" AND (biep80.IBLOCK_PROPERTY_ID=80 AND biep76.IBLOCK_PROPERTY_ID=76)
			-- AND (biep80equal71.IBLOCK_PROPERTY_ID=73 AND biep69.IBLOCK_PROPERTY_ID=69 
			--      AND biep68.IBLOCK_PROPERTY_ID=68 AND biep75.IBLOCK_PROPERTY_ID=75)";
			$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$ret=[];
			while($res = $ob ->fetch()){
				$ret[]=$res;
				}
			return $ret;
			
			
			}
		
		function viewDoc($id=''){
			if(!isset($DB)){global $DB;}
			$s="SELECT IBLOCK_ELEMENT_ID FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID=71 AND VALUE='$id'";
			
			false&&$ob = $DB->Query($s, false, $err_mess.__LINE__);
			$ret=[];
			if(false)while($res = $ob ->fetch()){
				$ret[]=$res['IBLOCK_ELEMENT_ID'];
				}
				
			$s="SELECT 
				biep.VALUE docnum,
				biep1.VALUE mean,
				biep2.VALUE count,
				biep3.VALUE quantity,
				biep4.VALUE links,
				biep5.VALUE etc,
				biep6.VALUE street,
				biep7.VALUE costbymean,
				biep8.VALUE costby,
				biep.IBLOCK_ELEMENT_ID,
				bie.NAME
				FROM b_iblock_element bie  
				LEFT JOIN b_iblock_element_property biep ON bie.ID=biep.IBLOCK_ELEMENT_ID and biep.IBLOCK_PROPERTY_ID=71
				LEFT JOIN b_iblock_element_property biep1 ON bie.ID=biep1.IBLOCK_ELEMENT_ID and biep1.IBLOCK_PROPERTY_ID=60 -- mera
				LEFT JOIN b_iblock_element_property biep2 ON bie.ID=biep2.IBLOCK_ELEMENT_ID and biep2.IBLOCK_PROPERTY_ID=61 -- 555
				LEFT JOIN b_iblock_element_property biep3 ON bie.ID=biep3.IBLOCK_ELEMENT_ID and biep3.IBLOCK_PROPERTY_ID=62 -- in upak
				LEFT JOIN b_iblock_element_property biep4 ON bie.ID=biep4.IBLOCK_ELEMENT_ID and biep4.IBLOCK_PROPERTY_ID=63 -- link
				LEFT JOIN b_iblock_element_property biep5 ON bie.ID=biep5.IBLOCK_ELEMENT_ID and biep5.IBLOCK_PROPERTY_ID=64 -- date
				LEFT JOIN b_iblock_element_property biep6 ON bie.ID=biep6.IBLOCK_ELEMENT_ID and biep6.IBLOCK_PROPERTY_ID=65 -- street
				LEFT JOIN b_iblock_element_property biep7 ON bie.ID=biep7.IBLOCK_ELEMENT_ID and biep7.IBLOCK_PROPERTY_ID=71 -- orient cost by 
				LEFT JOIN b_iblock_element_property biep8 ON bie.ID=biep8.IBLOCK_ELEMENT_ID and biep8.IBLOCK_PROPERTY_ID=66 -- orient cost
				LEFT JOIN b_iblock_element_property biep9 ON bie.ID=biep9.IBLOCK_ELEMENT_ID and biep9.IBLOCK_PROPERTY_ID=74 -- cost by
				-- LEFT JOIN b_iblock_element_property biep ON bie.ID=biep.IBLOCK_ELEMENT_ID
				WHERE biep.VALUE='$id'
				-- from oc 42291 60";
				
			if (!false)
				{
			$ret=[];
			$ob = $DB->Query($s, false, $err_mess.__LINE__);		
			while($res = $ob ->fetch()){
				$ret[]=$res;
				}
				
				}
				
				
			return $ret;
			}
			
	function miscDocrelevate($param=[]){
		if(!isset($DB)){global $DB;}
		$s="SELECT   
			FPV0.VALUE as way_77_VALUE,
			way_from_ib3.NAME as way_NAMEib,  
			FPV0.IBLOCK_ELEMENT_ID as way_IBID,
			FPV0.IBLOCK_PROPERTY_ID as way_prepID,
			'_' as delim, 
			FPEN0.ID as road_78_ID,
			FPEN0.PROPERTY_ID as road_78_prepID,
			FPEN0.VALUE as road_78_VALUE,
			'_' as similar,
			FPEN1.ID as road_69similar_ID,
			FPEN1.PROPERTY_ID as road_69similar_prepID,
			FPEN1.VALUE as road_69similar_VALUE
			FROM 
			b_iblock B
			INNER JOIN b_lang L ON B.LID=L.LID
			INNER JOIN b_iblock_element BE ON BE.IBLOCK_ID = B.ID
			LEFT JOIN b_iblock_property FP0 ON FP0.IBLOCK_ID = B.ID AND  FP0.ID=77
			LEFT JOIN b_iblock_property FP1 ON FP1.IBLOCK_ID = B.ID AND  FP1.ID=78
			LEFT JOIN b_iblock_element_property FPV0 ON FPV0.IBLOCK_PROPERTY_ID = FP0.ID AND FPV0.IBLOCK_ELEMENT_ID = BE.ID
			LEFT JOIN b_iblock_element_property FPV1 ON FPV1.IBLOCK_PROPERTY_ID = FP1.ID AND FPV1.IBLOCK_ELEMENT_ID = BE.ID
			LEFT JOIN b_iblock_property_enum FPEN0 ON FPEN0.PROPERTY_ID = FPV1.IBLOCK_PROPERTY_ID AND FPV1.VALUE_ENUM = FPEN0.ID
			LEFT JOIN b_iblock_property_enum FPEN1 ON FPEN1.PROPERTY_ID = 69 AND FPEN1.VALUE = FPEN0.VALUE
			LEFT JOIN b_iblock_element way_from_ib3 ON way_from_ib3.ID = FPV0.VALUE 
			WHERE 1=1 
			AND (
			((BE.IBLOCK_ID = '11'))
			-- AND ((BE.ID = '49411'))
			-- AND way_from_ib3.NAME='Поварское дело'
			-- AND FPEN0.VALUE='Региональный чемпионат 2019'
			-- AND FPV0.IBLOCK_ELEMENT_ID=49411 -- IDconcDoc
			)";
		
		}
		
}
if (isset($docr))
{
	$ret=new \MPrep;
	$ret=new \PageZayavkiNaMaterialyTabZayavkiNaMaterialy;
	// $ret=$ret->chek(71,422911);
	$ret=$ret->viewDoc(54401);
	// $ret=$ret->isDocEnableFor(42291);
	// $ret=$ret->viewListDocByUser(2645);
	print_r($ret);
	
}
