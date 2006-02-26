<?php

function addslashes_r(&$Array)
{
	foreach($Array as $Key => $Value)
	{
		if(is_array($Value)) addslashes_r($Array[$Key]);
		else $Array[$Key] = addslashes($Value);
	}
}

function stripslashes_r(&$Array)
{
	foreach($Array as $Key => $Value)
	{
		if(is_array($Value)) stripslashes_r($Array[$Key]);
		else $Array[$Key] = stripslashes($Value);
	}
	
	return $Array;
}

function Main_Dateformat($Unix)
{
	return date($GLOBALS['Config']['date_format'], $Unix);
}


function TimeToArray($Secs)
{
	$Return = array();
	
	$Year = (365*86400);
	
	$Return[4] = floor(($Secs / $Year)); // y
    $Return[0] = floor((($Secs % $Year) / 86400));  // d
	$Return[1] = floor(((($Secs % $Year) % 86400) / 3600)); // h
	$Return[2] = floor((((($Secs % $Year) % 86400) % 3600) / 60)); // m
	$Return[3] = floor(((($Secs % $Year) % 86400) % 3600) % 60); // s
		
	return $Return;
}

function Main_Checklogin(&$objUser)
{
	global $objSession;
	
	// Check for Login. If a session exists verify the password. If wrong -> Logout
	if($objSession->CheckLogin()) 
	{	
		if($objSession->GetData("name") == "Gast") $objSession->Logout();
		
		$objUser = new Nepama_User($objSession->GetData("name"));
		if($objUser->GetProperty("password") != $objSession->GetData("password")) $objSession->Logout();
	}
	
	// Check Login again, if no session exists create a Guestuser-object.
	if(!$objSession->CheckLogin()) 
	{
		// create guest-user and log in
		$objUser = new Nepama_User("Gast");
		//$objSession->Login(array("name" => "Gast", "password" => md5("gast")));
		return false;
	}
	
	return true;
}

function ifstr($C)
{
	return ($C == true ? "true" : "false");
}

?>