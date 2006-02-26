<?php

include("class.user.php");

class Module_User extends Nepama_Module
{
	public function Main()
	{
		$Do = isset($_GET['do']) ? $_GET['do'] : "";
		
		switch($Do)
		{
			case "login":
				return $this->ShowLogin();
			case "logout":
				return $this->ShowLogout();
			default:
				return $this->ShowLogin();
		}
	}
	
	private function ShowLogin()
	{
		if(isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['pass']))
			if(User::Login($_POST['name'], $_POST['pass']))
				return $this->ReturnTemplate("user_login_success");
			else
				return $this->ReturnTemplate("user_login_failed");
				
		return $this->ReturnTemplate("user_login");
	}
	
	private function ShowLogout()
	{
		User::Logout();
		
		return $this->ReturnTemplate("user_login");
	}
}

?>