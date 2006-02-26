<?php

include("class.admin.php");

class Module_Admin extends Nepama_Module
{
	public function Main()
	{
		global $objDb, $objTpl;
		
		if(isset($_GET['mod']))
		{
			$Mod = $_GET['mod'];
			
			$Rows = is_numeric($Mod) ? $objDb->Select(array("classname", "filename"), "modules", "WHERE id = '". intval($Mod) ."'") : $objDb->Select(array("classname", "filename"), "modules", "WHERE action = '". $Mod ."'");
			
			if($Rows != 0)
			{
				$ModData   = $objDb->FetchArray();
				$Classname = $ModData['classname'];
				$Filename  = $ModData['filename'];

				require(_PATH . "modules/" . $Filename);
				$Classname = "Module_" . $Classname;

				$objModule = new $Classname($objTpl);
				
				return $objModule->AdminMain();
			}
		}
		
		$Do = isset($_GET['do']) ? $_GET['do'] : "";
		switch($Do)
		{
			case "config":
				return $this->ShowConfig();
			case "menu":
				return $this->ShowMenu();
			case "module":
				return $this->ShowModule();
			default:
				return $this->ShowWelcome();
		}
	}
	
	public function ShowWelcome()
	{
		return $this->ReturnTemplate("admin_welcome");
	}
	
	public function ShowConfig()
	{
		global $objTpl;
		
		$ModuleId = isset($_GET['moduleid']) ? $_GET['moduleid'] : $this->ModuleId;
		
		if(isset($_POST['submit']))
		{
			unset($_POST['submit']);
			Admin::SaveConfig($ModuleId, $_POST);
		}
		
		$ConfigData = array();
		$Config = Admin::GetConfig($ModuleId);

		if($Config != false)
		{
			foreach($Config as $Value)
			{		
				if($Value['type'] == "SELECT" || $Value['type'] == "MSELECT")
				{
					if(preg_match("/^FUNCTION:(.*)$/", $Value['options'], $Match))
					{
						list($ModuleId, $Parameter) = explode(":", $Match[1]);
						$Module = Admin::GetModule($ModuleId, array("classfilename", "classname"));
	
						include_once(_PATH . "modules/". $Module['classfilename']);
						eval("\$Value['options'] = ". $Module['classname'] ."::MakeConfigOptions(\$Parameter);");
					}
					else
					{
						$OptArray = array();
						$Temp = explode("||", $Value['options']);
						foreach($Temp as $Option)
						{
							$Tmp = explode(">>", $Option);
							$OptArray[] = array($Tmp[0] => $Tmp[1]);
						}
					}
					
					$Value['selected'] = $Value['value'];
				}
				
				$ConfigData[] = $Value;

			}
		}

		$objTpl->assign("config", $ConfigData);
		$objTpl->assign("moduleid", $ModuleId);
		return $this->ReturnTemplate("admin_config");
	}
	
	public function ShowModule()
	{
		global $objTpl;
		
		$ModuleId = isset($_GET['moduleid']) ? intval($_GET['moduleid']) : 0;
		
		if($ModuleId == 0)
		{
			$ModuleList = Admin::GetModule(NULL, array("id", "name", "author", "version", "active"));
			$objTpl->assign("module", $ModuleList);
			
			return $this->ReturnTemplate("admin_module_list");
		}
		
		$Module = Admin::GetModule($ModuleId);
		
		if($Module == false)
		{
			unset($_GET['moduleid']);
			$this->ShowModule();
		}
	}
	
	public function ShowMenu()
	{	
		global $objTpl;
		
		$MenuId = isset($_GET['menuid']) ? intval($_GET['menuid']) : 0;
		
		// keine menuid gegeben => alle auflisten
		if($MenuId == 0)
		{
			$MenuList = Admin::GetMenus();
			$objTpl->assign("menulist", $MenuList);
			
			return $this->ReturnTemplate("admin_menu_list");
		}
		else
		{
			if($_GET['a'] == "edit")
			{
				if(isset($_POST['submit']))
				{
					echo "<pre>"; print_r($_POST); echo "</pre>";
				}
				
				$Name = Admin::GetMenu($MenuId, "name");
				
				$PointList = Admin::GetMenupoints($MenuId);
				
				$objTpl->assign("name", $Name);
				$objTpl->assign("id", $MenuId);
				
				$objTpl->assign("pointlist", $PointList);
				
				return $this->ReturnTemplate("admin_menu_menu");
			}
		}	
	}
}

?>