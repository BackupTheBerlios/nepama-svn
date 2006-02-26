<?php

include("class.article.php");

class Module_Article extends Nepama_Module
{
	public function Main()
	{
		$Do = isset($_GET['do']) ? $_GET['do'] : "";
		
		switch($Do)
		{
			case "show":
				return $this->ShowArticle();
			default:
				return $this->ShowArticleList();
		}
	}
	
	public function AdminMain()
	{
		$Do = isset($_GET['do']) ? $_GET['do'] : "";
		switch($Do)
		{
			case "list":
				return $this->AdminShowList();
			case "articleadd":
				return $this->AdminShowArticleAdd();
			case "articleedit":
				return $this->AdminShowArticleEdit();
			case "articledel":
				return $this->AdminShowArticleDel();
			default:
				return $this->AdminShowWelcome();
		}
	}
	
	private function AdminShowWelcome()
	{
		return $this->ReturnTemplate("admin_article_welcome");
	}
	
	private function AdminShowList()
	{
		global $objTpl, $objUser;
		
		$Page = isset($_GET['page']) ? intval($_GET['page']) : 0;
		$ArticleList = Article::GetArticleList(NULL, $Page);

		$objTpl->assign("articlelist", $ArticleList);
		
		$objTpl->assign("perpage", 10);
		$objTpl->assign("page", $Page);
		$objTpl->assign("count", Article::GetCount());
		
		return $this->ReturnTemplate("admin_article_list");
	}
	
	private function AdminShowArticleEdit()
	{
		global $objTpl, $objUser;
		
		$Id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		if(isset($_POST['submit']))
		{
			Article::SaveArticle($Id, array("title" => $_POST['title'], "content" => $_POST['content'], "date" => time(), "uid" => $objUser->GetProperty("id")));
		}
		
		$Article = Article::GetArticle($Id);
		
		if($Article == false) return $this->AdminShowList();
		
		$objTpl->assign("do", "articleedit&amp;id=". $Id);
		$objTpl->assign("title", $Article['title']);
		$objTpl->assign("content", $Article['content']);
		
		return $this->ReturnTemplate("admin_article_article");
	}	
	
	private function AdminShowArticleDel()
	{
		global $objTpl, $objUser;
		
		$Id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		
		if(isset($_POST['yes']))
		{
			Article::DeleteArticle($Id);
			return $this->AdminShowList();
		}
		elseif(isset($_POST['no']))
		{
			return $this->AdminShowList();
		}
		
		$Article = Article::GetArticle($Id);
		
		if($Article == false) return $this->AdminShowList();
		
		$objTpl->assign("id", $Id);
		$objTpl->assign("title", $Article['title']);
		
		return $this->ReturnTemplate("admin_article_confirm");
	}
	
	private function AdminShowArticleAdd()
	{
		global $objTpl, $objUser;
		
		if(isset($_POST['submit']))
		{
			$Id = Article::SaveArticle(NULL, array("title" => $_POST['title'], "content" => $_POST['content'], "date" => time(), "uid" => $objUser->GetProperty("id")));
			header("Location: ". _SCRIPTNAME ."?m=admin&mod=". $this->Action ."&do=articleedit&id=". $Id);
		}
		
		$objTpl->assign("do", "articleadd");
		$objTpl->assign("title", "");
		$objTpl->assign("content", "");
		
		return $this->ReturnTemplate("admin_article_article");
	}	
	
	private function ShowArticleList()
	{
		global $objTpl, $objUser;
		if($objUser->CheckRight("can_at_showlist") == false) return $this->ReturnError("RIGHTS: can_at_showlist");
		
		$Page = isset($_GET['page']) ? intval($_GET['page']) : 0;
		$ArticleList = Article::GetArticleList(NULL, $Page);

		$objTpl->assign("articlelist", $ArticleList);
		
		$objTpl->assign("perpage", 10);
		$objTpl->assign("page", $Page);
		$objTpl->assign("count", Article::GetCount());
		
		return $this->ReturnTemplate("article_list");
	}
	
	private function ShowArticle()
	{
		global $objTpl, $objUser;
		if($objUser->CheckRight("can_at_showarticle") == false) return $this->ReturnError("RIGHTS: can_at_showlist");
		
		$Id = isset($_GET['id']) ? intval($_GET['id']) : NULL;

		if($Id == NULL)
			return $this->ReturnTemplate("article_notexisting");
			
		$Article = Article::GetArticle($Id);
		
		if($Article == false)
			return $this->ReturnTemplate("article_notexisting");
	
		$objTpl->assign("title", $Article['title']);
		$objTpl->assign("content", $Article['content']);
		
		return $this->ReturnTemplate("article");
	}
}

?>