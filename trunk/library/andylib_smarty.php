<?php

class andylib_Smarty extends Smarty
{
	public $Styles = array();
	
	public function AddStyle($StyleDir)
	{
		$this->Styles[] = $StyleDir;
	}
	
	public function fetchf($File)
	{
		$Dirname = $Filename = "";
		$Styles = array_reverse($this->Styles);
		
		foreach($Styles as $Style)
		{
			$Dirname  = $this->template_dir . $Style;
			$Filename = $this->template_dir . $Style . $File;

			if(file_exists($Filename))
				break;
		}
		
		if($Dirname != "" && $Filename != "")
		{
			$this->assign("templatedir", "templates/" . $Style);
			$this->assign("imagedir", "templates/" . $Style . "images/");
			
			$Data = $this->fetch($Style . $File);
			
			return $Data;
		} 
		else
			return false;
	}
}

?>