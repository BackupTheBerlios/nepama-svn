<?php

class News 
{
	public function GetCount()
	{
		global $objDb;
		
		return $objDb->Select("COUNT(id)", "mod_nw_news");
	}
	
	public function GetNewsList($Fields = NULL, $Page = 0, $Perpage = 5)
	{
		global $objDb;
		
		if($Fields == NULL)
			$Fields = array("News" => array("id", "title", "uid", "date"), "user" => array("name"));
		
		/* page management */
		$Offset = $Page * $Perpage;
		
		$Rows = $objDb->Select($Fields, array("mod_nw_news" => "News", "users" => array("LEFT JOIN", "user", "user.id = News.uid")), "LIMIT ". $Offset .", ". $Perpage);

		if($Rows == 0)
			return false;	
		
		$Data = array(); $i = 0;
		while($x = $objDb->FetchArray())
		{
			foreach($x as $Key => $Field)
			{	
				if($Key == "date") $Data[$i][$Key] = Main_Dateformat($Field);
				else $Data[$i][$Key] = stripslashes($Field);
			}
			
			$i++;
		}
			
		return $Data;
	}
		
	public function GetNews($Id, $Fields = array("News" => array("id", "title", "content", "uid", "date"), "user" => array("name")))
	{
		global $objDb;

		$Rows = $objDb->Select($Fields, array("mod_nw_news" => "News", "users" => array("LEFT JOIN", "user", "user.id = News.uid")), "WHERE News.`id` = '". $Id ."'");

		if($Rows == 0)
			return false;

		$Data = $objDb->FetchArray();
		
		foreach($Data as $Key => $Field)
		{	
			if($Key == "date") $Data[$Key] = Main_Dateformat($Field);
			else $Data[$Key] = stripslashes($Field);
		}
		
		return $Data;
	}
	
	public function SaveNews($Id, $Data)
	{
		global $objDb;
		
		if($Id != NULL)
			$objDb->Update("mod_nw_news", $Data, "WHERE `id` = '". $Id ."'");
		else
		{
			$objDb->Insert("mod_nw_news", $Data);
			return $objDb->InsertId("mod_nw_news");
		}
	}
	
	public function DeleteNews($Id)
	{
		global $objDb;
		
		$objDb->Delete("mod_nw_news", "WHERE `id` = '". $Id ."'");
	}
}