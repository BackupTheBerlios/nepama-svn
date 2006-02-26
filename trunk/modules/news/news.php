<?php

include("class.news.php");

class Module_News extends Nepama_Module
{
	public function Main()
	{
		$Do = isset($_GET['do']) ? $_GET['do'] : "";
		
		switch($Do)
		{
			case "show":
				return $this->ShowNews();
			default:
				return $this->ShowNewsList();
		}
	}
	
	public function AdminMain()
	{
		$Do = isset($_GET['do']) ? $_GET['do'] : "";
		switch($Do)
		{
			case "list":
				return $this->AdminShowList();
			case "newsadd":
				return $this->AdminShowNewsAdd();
			case "newsedit":
				return $this->AdminShowNewsEdit();
			case "newsdel":
				return $this->AdminShowNewsDel();
			default:
				return $this->AdminShowWelcome();
		}
	}
	
	private function AdminShowWelcome()
	{
		return $this->ReturnTemplate("admin_news_welcome");
	}
	
	private function AdminShowList()
	{
		global $objTpl, $objUser;
		
		$Page = isset($_GET['page']) ? intval($_GET['page']) : 0;
		$NewsList = News::GetNewsList(NULL, $Page);

		$objTpl->assign("newslist", $NewsList);
		
		$objTpl->assign("perpage", 10);
		$objTpl->assign("page", $Page);
		$objTpl->assign("count", News::GetCount());
		
		return $this->ReturnTemplate("admin_news_list");
	}
	
	private function AdminShowNewsEdit()
	{
		global $objTpl, $objUser;
		
		$Id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		if(isset($_POST['submit']))
		{
			News::SaveNews($Id, array("title" => $_POST['title'], "content" => $_POST['content'], "date" => time(), "uid" => $objUser->GetProperty("id")));
		}
		
		$News = News::GetNews($Id);
		
		if($News == false) return $this->AdminShowList();
		
		$objTpl->assign("do", "newsedit&amp;id=". $Id);
		$objTpl->assign("title", $News['title']);
		$objTpl->assign("content", $News['content']);
		
		return $this->ReturnTemplate("admin_news_news");
	}	
	
	private function AdminShowNewsDel()
	{
		global $objTpl, $objUser;
		
		$Id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		
		if(isset($_POST['yes']))
		{
			News::DeleteNews($Id);
			return $this->AdminShowList();
		}
		elseif(isset($_POST['no']))
		{
			return $this->AdminShowList();
		}
		
		$News = News::GetNews($Id);
		
		if($News == false) return $this->AdminShowList();
		
		$objTpl->assign("id", $Id);
		$objTpl->assign("title", $News['title']);
		
		return $this->ReturnTemplate("admin_news_confirm");
	}
	
	private function AdminShowNewsAdd()
	{
		global $objTpl, $objUser;
		
		if(isset($_POST['submit']))
		{
			$Id = News::SaveNews(NULL, array("title" => $_POST['title'], "content" => $_POST['content'], "date" => time(), "uid" => $objUser->GetProperty("id")));
			header("Location: ". _SCRIPTNAME ."?m=admin&mod=". $this->Action ."&do=newsedit&id=". $Id);
		}
		
		$objTpl->assign("do", "newsadd");
		$objTpl->assign("title", "");
		$objTpl->assign("content", "");
		
		return $this->ReturnTemplate("admin_news_news");
	}	
	
	private function ShowNewsList()
	{
		global $objTpl, $objUser;
		if($objUser->CheckRight("can_nw_showlist") == false) return $this->ReturnError("RIGHTS: can_nw_showlist");
		
		$Page = isset($_GET['page']) ? intval($_GET['page']) : 0;
		$NewsList = News::GetNewsList(array("News" => array("id", "title", "uid", "date", "content"), "user" => array("name")), $Page);

		$objTpl->assign("newslist", $NewsList);
		
		$objTpl->assign("perpage", 10);
		$objTpl->assign("page", $Page);
		$objTpl->assign("count", News::GetCount());
		
		return $this->ReturnTemplate("news_list");
	}
	
	private function ShowNews()
	{
		global $objTpl, $objUser;
		if($objUser->CheckRight("can_nw_shownews") == false) return $this->ReturnError("RIGHTS: can_nw_showlist");
		
		$Id = isset($_GET['id']) ? intval($_GET['id']) : NULL;

		if($Id == NULL)
			return $this->ReturnTemplate("news_notexisting");
			
		$News = News::GetNews($Id);
		
		if($News == false)
			return $this->ReturnTemplate("news_notexisting");
	
		$objTpl->assign("title", $News['title']);
		$objTpl->assign("content", $News['content']);
		$objTpl->assign("name", $News['name']);
		$objTpl->assign("date", $News['date']);
		
		return $this->ReturnTemplate("news");
	}
}

?>