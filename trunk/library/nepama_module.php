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

class Nepama_Module
{
	protected $Action;
	protected $ModuleId;
	protected $TemplateDir;
	
	public function __construct()
	{
		global $objTpl;
		$this->_GetModuleInfo();
		
		$objTpl->assign("module_action", $this->Action);
		$objTpl->assign("module_id", $this->ModuleId);
	}
	 
	public function Main()
	{
		return "";
	}
	
	protected function ReturnTemplate($Template)
	{
		return $GLOBALS['objTpl']->fetchf("modules/" . $this->TemplateDir . $Template . ".tpl");
	}
	
	protected function ReturnError($Msg = "")
	{
		$GLOBALS['objTpl']->assign("errormsg", $Msg);
		return $GLOBALS['objTpl']->fetchf("modules/error.tpl");
	}
	
	protected function _GetModuleInfo()
	{
		global $objDb;

		$Classname = substr(get_class($this), 7);
		$objDb->Select(array("action", "id", "filename"), "modules", "WHERE classname = '$Classname'");
		$x = $objDb->FetchArray();
		
		$this->Action = $x['action'];
		$this->ModuleId = $x['id'];
		$this->TemplateDir = substr($x['filename'], 0, strrpos($x['filename'], "/") + 1);
	}	
	
}

?>
