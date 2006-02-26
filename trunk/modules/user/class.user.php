<?php

class User
{
	public function Login($Name, $Pass)
	{
		global $objSession;
		
		$tmpUser = new Nepama_User($Name);
		
		if($tmpUser == false)
			return false;
			
		$tmpPass = $tmpUser->GetProperty("password");
		if($tmpPass == md5($Pass))
		{
			$objSession->Login(array("name" => $Name, "password" => $tmpPass));
			return true;
		}
		
		return false;
	}
	
	public function Logout()
	{
		global $objSession;
		
		$objSession->Logout();
	}
}

?>