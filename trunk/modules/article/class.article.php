<?php

class Article 
{
	public function GetCount()
	{
		global $objDb;
		
		return $objDb->Select("COUNT(id)", "mod_at_articles");
	}
	
	public function GetArticleList($Fields = NULL, $Page = 0, $Perpage = 10)
	{
		global $objDb;
		
		if($Fields == NULL)
			$Fields = array("article" => array("id", "title", "uid", "date"), "user" => array("name"));
		
		/* page management */
		$Offset = $Page * $Perpage;
		
		$Rows = $objDb->Select($Fields, array("mod_at_articles" => "article", "users" => array("LEFT JOIN", "user", "user.id = article.uid")), "LIMIT ". $Offset .", ". $Perpage);

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
		
	public function GetArticle($Id, $Fields = array("article" => array("id", "title", "content", "uid", "date"), "user" => array("name")))
	{
		global $objDb;

		$Rows = $objDb->Select($Fields, array("mod_at_articles" => "article", "users" => array("LEFT JOIN", "user", "user.id = article.uid")), "WHERE article.`id` = '". $Id ."'");

		if($Rows == 0)
			return false;

		$Data = $objDb->FetchArray();
		$Data['title'] = stripslashes($Data['title']);
		$Data['content'] = stripslashes($Data['content']);
		$Data['name'] = stripslashes($Data['name']);
		
		return $Data;
	}
	
	public function SaveArticle($Id, $Data)
	{
		global $objDb;
		
		if($Id != NULL)
			$objDb->Update("mod_at_articles", $Data, "WHERE `id` = '". $Id ."'");
		else
		{
			$objDb->Insert("mod_at_articles", $Data);
			return $objDb->InsertId("mod_at_articles");
		}
	}
	
	public function DeleteArticle($Id)
	{
		global $objDb;
		
		$objDb->Delete("mod_at_articles", "WHERE `id` = '". $Id ."'");
	}
}