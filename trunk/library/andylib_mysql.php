<?php

if(!defined("MAIN")) exit();
	
class andylib_MySQL
{
	private $LinkId;
	private $LastQueryResource;
	private $LastQueryString;
	private $QueryCount;
	
	private $Config;
	
	public function __construct($Host, $User, $Password, $Database, $Prefix)
	{
		$this->Config = array("host" => $Host, "user" => $User, "pass" => $Password, "dbase" => $Database, "prefix" => $Prefix);
		$this->LinkId = NULL;
		$this->LastQueryResource = NULL;
	}
	
	public function __destruct()
	{
		$this->Close();
		
		unset($this->LastQueryResource);
		unset($this->Config);
	}
	
	public function SetConfig($Key, $Value)
	{
		$this->Config[$Key] = $Value;
	}
	
	public function GetConfig($Key)
	{
		if(isset($this->Config[$Key]))
			return $this->Config[$Key];
	}
	
	public function Connect()
	{
		$this->LinkId = mysql_connect($this->Config['host'], $this->Config['user'], $this->Config['pass']);
		
		if($this->LinkId == false)
		{
			// put error.
		}
		else
			$this->SelectDatabase($this->Config['dbase']);
	}
	
	public function Close()
	{
		if($this->LinkId != false)
		{
			mysql_close($this->LinkId);
			$this->LinkId == false;
		}
	}
	
	public function IsConnected()
	{
		return ($this->LinkId == false ? false : true);
	}
	
	public function SelectDatabase($Database)
	{
		if(mysql_select_db($Database, $this->LinkId) == false)
		{
			// put error.
		}
	}
	
	public function Query($String, $Unbuffered = false)
	{
		if(!$this->IsConnected()) return false;
		
		$this->LastQueryString = $String;
		$this->QueryCount++;
		
		if($Unbuffered == false)
			$this->LastQueryResource = mysql_query($String, $this->LinkId);
		else
			$this->LastQueryResource = mysql_unbuffered_query($String, $this->LinkId);
		
		if($this->LastQueryResource == false)
		{
			trigger_error(mysql_error());
		}
	}
	
	public function GetResource()
	{
		return $this->LastQueryResource;
	}
	
	public function NumRows()
	{
		if($this->GetResource() == false)
			return 0;
		else
			return mysql_num_rows($this->GetResource());
	}
	
	public function AffectedRows()
	{
		if($this->IsConnected() == false)
			return 0;
		else
		return mysql_affected_rows($this->LinkId);
	}
	
	public function FetchArray($Resource = NULL, $Mode = MYSQL_ASSOC)
	{
		if($Resource == NULL)
			$Resource = $this->GetResource();
			
		if($Resource == false)
			return false;
		
		$Data = mysql_fetch_array($Resource, $Mode);
		return $Data;
	}
	
	public function Result($Row = 0, $Field = NULL)
	{
		$Resource = $this->GetResource();
			
		if($Resource == false)
			return false;
		
		$Data = mysql_result($Resource, $Row, $Field);
		return $Data;	
	}
	
	public function InsertId($Table)
	{
		$Table  = "`". $this->GetConfig("prefix") . "_" . $Table ."`";
		$this->Query("SELECT LAST_INSERT_ID() FROM ". $Table);
		
		return $this->Result(0);
	}
	
	public function Escape($String)
	{
		return mysql_real_escape_string($String, $this->LinkId);
	}
	
	// select
	/*
	  andylib_MySQL::Select("field", "table", "WHERE ...");
	  andylib_MySQL::Select(array("field1", "field2"), "table", "WHERE ...");
	  andylib_MySQL::Select(array("alias" => array("field1", "field2"), "alias2" => array("field3", "field4")), array("table" => "alias", "table2" => array("LEFT JOIN", "alias2", "alias2.id = alias.id")), "WHERE ...");
	*/
	public function Select($Fields, $Table, $Condition = "")
	{
		// case 1: $Fields is only one field - perform query and return the result directly
		if(is_string($Fields))
		{
			if($Fields == "COUNT(id)") $Field = "COUNT(id)";
			else $Field  = "`". $Fields ."`";
			
			$Table  = "`". $this->GetConfig("prefix") . "_" . $Table ."`";
			
			$QueryString = "SELECT {$Field} FROM {$Table} {$Condition}";
			$this->Query($QueryString);
			
			if($this->NumRows() == 0) return false;
			
			return $this->Result(0);
		}
		
		// case 2: $Fields is an array - perform query and return mysql_num_rows()
		if(is_array($Fields))
		{
			$Field = "";
			
			foreach($Fields as $Key => $Value)
			{
				if(is_array($Value))
					foreach($Value as $JoinKey => $JoinField)
					{
						if(!is_numeric($JoinKey))
							if($JoinKey == "COUNT(id)")
								$Field .= "COUNT(". $Key .".id) AS `". $JoinField ."`, ";
							else
								$Field .= $Key .".`". $JoinKey ."` AS `". $JoinField ."`, ";
						else
							if($JoinField == "COUNT(id)")
								$Field .= "COUNT(". $Key .".id), ";
							else
								$Field .= $Key .".`". $JoinField ."`, ";
					}
				else	
					$Field .= "`". $Value ."`, ";
			}
						
			$Tables = "";
			$Joins  = "";
			
			if(is_string($Table))
				$Tables  = "`". $this->GetConfig("prefix") . "_" . $Table ."`, ";
			else
			{
				foreach($Table as $Key => $Value)
				{
					if(is_array($Value))
						$Joins .= $Value[0] ." ". $this->GetConfig("prefix") . "_" . $Key ." AS `". $Value[1] ."` ON ". $Value[2] ." ";
					else
						$Tables .= "`". $this->GetConfig("prefix") . "_" . $Key ."` AS `". $Value ."`, ";
				}
			}
			
			$Field = substr(trim($Field), 0, -1);
			$Tables = substr(trim($Tables), 0, -1);
			
			$QueryString = "SELECT {$Field} FROM {$Tables} {$Joins} {$Condition}";
			$this->Query($QueryString);
			
			#echo "<pre>". $QueryString ."</pre>";
			
			return $this->NumRows();
		}
	}	
	
	public function Insert($Table, $Fields)
	{
		$Table  = "`". $this->GetConfig("prefix") . "_" . $Table ."`";
		$Field = "";
		
		foreach($Fields as $Key => $Value)
			$Field .= "`". $Key ."` = '". $Value ."', ";
		
		$Field = substr(trim($Field), 0, -1);
		
		$QueryString = "INSERT INTO {$Table} SET {$Field}";
		$this->Query($QueryString);
		
		return $this->AffectedRows();
	}
	
	public function Update($Table, $Fields, $Condition = "")
	{
		$Table  = "`". $this->GetConfig("prefix") . "_" . $Table ."`";
		$Field = "";
		
		foreach($Fields as $Key => $Value)
		{
			if(strlen($Value) != 0)
				$Field .= "`". $Key ."` = ". ($Value{0} != "`" ? "'". $Value ."'" : $Value) .", ";
			else
				$Field .= "`". $Key ."` = '". $Value ."', ";
		}
		
		$Field = substr(trim($Field), 0, -1);
		
		$QueryString = "UPDATE {$Table} SET {$Field} {$Condition}";
		$this->Query($QueryString);
		
		return $this->AffectedRows();
	}
	
	public function Delete($Table, $Condition = "")
	{
		$Table  = "`". $this->GetConfig("prefix") . "_" . $Table ."`";
		
		$QueryString = "DELETE FROM {$Table} {$Condition}";
		$this->Query($QueryString);
		
		return $this->AffectedRows();
	}
}

?>
