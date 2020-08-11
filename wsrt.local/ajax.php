<?

if (empty($_SERVER['DOCUMENT_ROOT'])) {
	$islcl = 1;
	if (!extension_loaded('mysqli')) {
		// if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		dl('php_mysqli.dll');
		// } else {
		// dl('sqlite.so');
		// }
	}

	$docr = explode('\\', __FILE__);
	unset($docr[count($docr) - 1]);
	$docr = implode('/', $docr);
	$docr = "u:/wsrt";
	$_SERVER["DOCUMENT_ROOT"] = $docr;

	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


}

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
IncludeModuleLangFile(__FILE__);

if (!check_bitrix_sessid() || $_SERVER["REQUEST_METHOD"] != "POST") {
	!isset($docr) && die('success');
}

global $USER, $APPLICATION;

// na_sluchay_ne_utf
CUtil::JSPostUnescape();

$module_id = "wsrt.local";
CModule::IncludeModule($module_id);

$answer = Array();
$answer["success"] = false;

if ($_POST['login']) { // обманка - защита от спама
	echo json_encode($answer);
	die();
}
if (!$_POST['page']) { // ещё защита от спама
	echo json_encode($answer);
	!isset($docr) && die();
}

if ($_POST['action'] == "search-answers") {
	$answer = LocExec::searchOffers($_REQUEST['query']);
}

if ($_POST['action'] == "ask-question") {
	$answer = LocExec::askOffers($_POST['question'], $_POST['email']);
	if (LANG_CHARSET != 'UTF-8') {
		$answer["answer"] = iconv(LANG_CHARSET, 'UTF-8', $answer["answer"]);
	}
}
/*$_POST['action'] ="whatis";
global  $USER ;
	if (!$USER->IsAuthorized())
	{
		 // $USER ->Authorize(2645);	
	}*/
if ($_POST['action'] == "whatis") {
	$answer["answer"] = \LocExec::getUserId();
}

if ($_POST['action'] == "viewDoc" and isset($_POST['query'])) {

	$ret = new \MPrep;
	// $ret=$ret->chek(71,422911);
	$ret = $ret->viewDoc((int)$_POST['query']);
	echo json_encode($ret);
	return;
	// print_r($ret);	
// $answer["answer"]=\LocExec::getUserId();
}

function ghg()
{

	$jayParsedAry = [
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


}

echo json_encode($answer);
