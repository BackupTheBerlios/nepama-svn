<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {counter} function plugin
 *
 * blah blah
 */
function smarty_function_pagelist($params, &$smarty)
{
	$Perpage 	 = $params['perpage'];
	$Currentpage = $params['currentpage'];
	$Count 		 = $params['count'];
	$Link 		 = $params['link'];
	$Sep 		 = $params['sep'];

	$Start = $Currentpage * $Perpage;
	$End = $Start + $Perpage;
	
	$PageStr = "";
	$Pages = ceil($Count/$Perpage);
	for($i = 1; $i <= $Pages; $i++)
		$PageStr .= "<a href=\"". $Link . ($i-1) ."\">". $i ."</a>". $Sep;
		
	$PageStr = substr($PageStr, 0, -1 * strlen($Sep));
	
	$Tpl = "<div class=\"post\"><p class=\"small\">Zeige Einträge %show_start% bis %show_end% von %show_total%. Seiten (%page_total%): %pages%</p></div>";
	
	return str_replace(array("%show_start%", "%show_end%", "%show_total%", "%pages%", "%page_total%"), array($Start+1, ($End <= $Count ? $End : $Count), $Count, $PageStr, $Pages), $Tpl);
}

?>