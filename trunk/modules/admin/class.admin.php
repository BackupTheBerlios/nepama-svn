<?php

class Admin
{
	public function GetConfig($ModuleId, $Fields = array("id", "mid", "name", "desc", "type", "options", "value"))
	{
		global $objDb;
		
		$Rows = $objDb->Select($Fields, "config_new", "WHERE `mid` = '$ModuleId'");
		if($Rows == 0)
			return false;
		
		$Data = array();
		while($x = $objDb->FetchArray())
			$Data[] = stripslashes_r($x);
			
		return $Data;
	}
	
	public function SaveConfig($ModuleId, $Values)
	{
		global $objDb;
		
		foreach($_POST as $Key => $Value)
			$objDb->Update("config_new", array("value" => $Value), "WHERE `mid` = '$ModuleId' AND `name` = '$Key'");
	}
	
	public function GetModule($ModuleId, $Fields = array("id", "name", "author", "version", "classname", "filename", "classfilename", "action", "menu", "active"))
	{
		global $objDb;
		
		$Data = NULL;
		if($ModuleId != NULL)
		{
			$Rows = $objDb->Select($Fields, "modules", "WHERE `id` = '$ModuleId'");
			if($Rows == 0)
				return false;
			
			$Data = $objDb->FetchArray();
			stripslashes_r($Data);
		}
		else
		{
			$Rows = $objDb->Select($Fields, "modules");
			if($Rows == 0)
				return false;
				
			while($x = $objDb->FetchArray())
				$Data[] = stripslashes_r($x);
		}
		
		return $Data;
	}
	
	public function GetMenus($Fields = array("id", "name"))
	{
		global $objDb;
		
		$Data = array();
		$objDb->Select($Fields, "menus");
		while($x = $objDb->FetchArray())
		{
			$Data[] = array("id" => $x['id'], "name" => stripslashes($x['name']));
		}
		
		return $Data;
	}
	
	public function GetMenu($Id, $Fields = "name")
	{
		global $objDb;
		
		return stripslashes($objDb->Select($Fields, "menus", "WHERE `id` = '". $Id ."'"));
	}
	
	public function GetMenupoints($MenuId, $Fields = array("id", "title"))
	{
		global $objDb;
		
		$Data = array();
		$objDb->Select($Fields, "menupoints", "WHERE `mid` = '". $MenuId ."'");
		while($x = $objDb->FetchArray())
		{
			$Data[] = array("id" => $x['id'], "title" => stripslashes($x['title']));
		}
		
		return $Data;
	}
	
	public function MakeConfigOptions($Parameter)
	{
		switch($Parameter)
		{
			case "default_module":
				$Modules = Admin::GetModule(NULL, array("id", "name"));
				$Options = array();
				foreach($Modules as $Value)
					$Options[$Value['id']] = $Value['name'];
					
				return $Options;
		}
	}
}

?>