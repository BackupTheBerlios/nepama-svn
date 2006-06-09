<?php

define("STARTTIME", microtime(true));
define("_SCRIPTNAME", "main.php5");

define("MAIN", "true");

/** DEVELOPERS NOTE
 * set some ini-values to kill magic quotes
*/
ini_set("magic_quotes_gpc", 0);
ini_set("magic_quotes_runtime", 0);

/** DEVELOPERS NOTE
 * activate output buffering / compression
*/
ini_set('zlib.output_compression_level', 2);
ob_start('ob_gzhandler');

ini_set("allow_call_time_pass_reference", true);

/** DEVELOPERS NOTE
 * include general include file
*/
require("includes.php");

if(!defined("_DEBUGLVL")) 
	define("_DEBUGLVL", 3);

/** DEVELOPERS NOTE
 * add the styles in the right order
 * TODO: make it dynamically configable
*/
$objTpl->AddStyle("default/");

/** DEVELOPERS NOTE
 * load default configuration from db
*/
$objDb->Select(array("name", "value"), "config_new", "WHERE `mid` = '3'");
while($x = $objDb->FetchArray())
{
	$Config[stripslashes($x['name'])] = stripslashes($x['value']);
}

/** DEVELOPERS NOTE
 * security: escape the $_POST/$_GET values
*/
addslashes_r($_POST);
addslashes_r($_GET);

/** DEVELOPERS NOTE
 * initialize user-object and check for loginstate
*/
$objUser = NULL;
$StateFirst = Main_Checklogin($objUser);

/** DEVELOPERS NOTE
 * get module from querystring and fetch data from db
*/
$Module = (isset($_GET['m'])) ? $_GET['m'] : "";

$Rows = is_numeric($Module) ? $objDb->Select(array("classname", "filename", "menu"), "modules", "WHERE id = '". intval($Module) ."'") : $objDb->Select(array("classname", "filename", "menu"), "modules", "WHERE action = '". $Module ."'");

/** DEVELOPERS NOTE
 * load default module if requested is not found
*/
if($Rows == 0) 
{
	$objDb->Select(array("classname", "filename", "menu"), "modules", "WHERE id = '". $Config['default_module'] ."'");
	
	// parsing default parameters
	if(!empty($Config['default_parameters']))
	{
		$Tmp = explode(";", $Config['default_parameters']);
		foreach($Tmp as $Part)
		{
			list($Key, $Val) = explode("=", $Part);
			$_GET[$Key] = $Val;
		}
	}
}

/** DEVELOPERS NOTE
 * loading and parsing the module
*/
$ModData   = $objDb->FetchArray();
$Classname = $ModData['classname'];
$Filename  = $ModData['filename'];
$MenuId    = $ModData['menu'];

require(_PATH . "modules/" . $Filename);
$Classname = "Module_" . $Classname;

$objModule = new $Classname($objTpl);
$MainContent = $objModule->Main();

$objTpl->assign("maincontent", $MainContent);

/** DEVELOPERS NOTE
 * reinitialize userstate - it could have changed during the module process
*/
$objUser = NULL;
$State = Main_Checklogin($objUser);

$objTpl->assign("session_user", $objUser->GetProperty("name"));
$objTpl->assign("session_login", ifstr($State));

$GroupId = $objUser->GetProperty("groupid");	

/** DEVELOPERS NOTE
 * generate the menu
*/
//$MenuId = 1;
$MenuData = array();
$Rows = $objDb->Select(array("title", "link"), "menupoints", "WHERE `mid` = '$MenuId' AND `access` LIKE '%,$GroupId,%' ORDER BY `order`");
if($Rows == 0) 
	$objTpl->assign("menu", array());
else
	while($x = $objDb->FetchArray())
		$MenuData[] = array("title" => stripslashes($x['title']), "link" => stripslashes($x['link']), "islink" => (strlen($x['link']) > 0 ? "true" : "false"));
	
$objTpl->assign("menu", $MenuData);

/** DEVELOPERS NOTE
 * set some variables
*/
$objTpl->assign("nepa_version", _VERSION);
$objTpl->assign("nepa_codename", _CODENAME);
$objTpl->assign("page_title", $Config['page_title']);
$objTpl->assign("script_name", _SCRIPTNAME);

/** DEVELOPERS NOTE
 * parse template and return it
*/
$Data = $objTpl->fetchf("main.tpl");
$Data = str_replace("\$\$", _SCRIPTNAME, $Data);

print(str_replace("#DEBUGDATA#", round((microtime(true) - STARTTIME) * 1000, 2) . "µs", $Data));

?>