<?php

/* ************************************************************************** *\
 * nepama - Network Party Manager                                             *
 * Copyright (C) 2005-2006 Philipp 'andy' Waldhauer                           *
 *                                                                            *
 * This program is free software; you can redistribute it and/or              *
 * modify it under the terms of the GNU General Public License                *
 * as published by the Free Software Foundation; either version 2             *
 * of the License, or (at your option) any later version.                     *
 *                                                                            *
 * This program is distributed in the hope that it will be useful,            *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of             *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the              *
 * GNU General Public License for more details.                               *
 *                                                                            *
 * You should have received a copy of the GNU General Public License          *
 * along with this program; if not, write to the Free Software                *
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301.  *
\* ************************************************************************** */

if(!defined("MAIN")) exit();

define('ERROR', E_USER_ERROR);
define('WARNING', E_USER_WARNING);
define('NOTICE', E_USER_NOTICE);

function Nepama_ErrorHandler($ErrNo, $ErrStr, $ErrFile, $ErrLine)
{
	if(_DEBUGLVL == 0) return;
	if(_DEBUGLVL == 1 && ($ErrNo == 8 || $ErrNo = NOTICE)) return;
	
	$Output = "<div style=\"font-family: Verdana; font-size: 10px; padding: 5px; border: 1px #000 solid; background-color: #999; width: 50%; margin: auto;\"><strong>nepama-" . _VERSION ." Errorhandler.</strong><br/><br/>We got an error #$ErrNo in '$ErrFile' on line $ErrLine.<br/>&#187; PHP says: '" . htmlentities($ErrStr) . "'<br/><br/>";
		
	$Backtrace = debug_backtrace();
	
	$Output .= "&#187; Backtrace:<br/><ul style=\"border: 1px #000 solid; padding: 0px; margin: 0px; list-style-type: none; display: block;\">";
	
	for($i = 0; $i < count($Backtrace); $i++)
	{
		$Color = dechex(abs(255 - ($i*35))); 
		$Output .= "<li style=\"padding: 2px; background-color: #{$Color}0000;\">#" . ($i+1) . " '" . $Backtrace[$i]['function'] . 
				"'" . (isset($Backtrace[$i]['class']) ?  " (Class: ". $Backtrace[$i]['class'] .") " : " "). 
				"in '" . (isset($Backtrace[$i]['file']) ? $Backtrace[$i]['file'] : "n/a") . "' (" . (isset($Backtrace[$i]['line']) ? $Backtrace[$i]['line'] : "n/a") . ")";
				
		if(_DEBUGLVL == 3 && count($Backtrace[$i]['args']) > 0)
			$Output .= "<br/>&nbsp;&nbsp;&nbsp;(Args: ". FormArguments(", ", $Backtrace[$i]['args']) .")";
			
		$Output .= "</li>";
	} 
	
	$Output .= "</ul></div><br/><br/>";	
	echo $Output;
}

function FormArguments($Glue, $Args)
{
	$Return = "";
	
	foreach($Args as $Argument)
	{
		if(!is_array($Argument)) 
		{
			if(is_string($Argument)) $Argument = htmlentities(substr($Argument, 0, 20)) . "...";
			$Return .= $Argument . $Glue;
		}
		elseif(is_array($Argument) && array_key_exists("GLOBALS", $Argument)) $Return .= "RECURSION". $Glue;
		else $Return .= "Array(". FormArguments($Glue, $Argument) .")". $Glue;
	}
	
	return substr($Return, 0, -strlen($Glue));
}

?>
