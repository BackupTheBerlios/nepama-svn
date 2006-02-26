<?php

/* ************************************************************************** *\
 * nepama - Network Party Manager                                             *
 * Copyright (C) 2005-2006 Philipp 'andy' Waldhauer                           *
 *                                                                            *
 * This program is free software; you can redistribute it and/or              *
 * modify it under the terms of the GNU General Public License                *
 * as published by the Free Software Foundation; either version 2             *
 * of the License, or (at your option) any later version.                     *
 *                                                                            *
 * This program is distributed in the hope that it will be useful,            *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of             *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the              *
 * GNU General Public License for more details.                               *
 *                                                                            *
 * You should have received a copy of the GNU General Public License          *
 * along with this program; if not, write to the Free Software                *
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301.  *
\* ************************************************************************** */

class Nepama_Session
{
	private $SessionData;
	private $LoggedIn;
	
	public function __construct()
	{
		$this->SessionData = array();
		$this->LoggedIn = false;
		
		if(isset($_SESSION['nepa_loggedin']) && isset($_SESSION['nepa_data']))
		{
			$this->LoggedIn = true;
			$this->SessionData = $_SESSION['nepa_data'];
			return true;
		}

		if(isset($_COOKIE['nepama_loggedin']) && $_COOKIE['nepama_loggedin'] == true && isset($_COOKIE['nepama_data']))
		{		
			$_SESSION['nepa_loggedin'] = true;
			$_SESSION['nepa_data'] = unserialize(base64_decode($_COOKIE['nepama_data']));
			
			$this->__construct();
		}
		
		return false;
	}
	
	public function Login($Data)
	{
		$_SESSION['nepa_loggedin'] = true;
		$_SESSION['nepa_data'] = $Data;
		
		// cookies
		setcookie("nepama_loggedin", "true", time()+4*7*86400);
		setcookie("nepama_data", base64_encode(serialize($Data)), time()+4*7*86400);
		
		// reload cached
		$this->LoggedIn = true;
		$this->SessionData = $Data;
	}
	
	public function Logout()
	{
		unset($_SESSION['nepa_loggedin']);
		unset($_SESSION['nepa_data']);
		
		setcookie("nepama_loggedin", "false", time()-5);
		setcookie("nepama_data", "false", time()-5);
		
		// reload cached
		$this->LoggedIn = false;
		$this->SessionData = array();
	}
	
	public function CheckLogin()
	{
		return $this->LoggedIn;
	}
	
	public function GetData($Index)
	{
		if(isset($this->SessionData[$Index]))
		{
			return $this->SessionData[$Index];
		}
		else
		{
			return NULL;
		}
	}
	
	public function SetData($Data)
	{
		foreach($Data as $Key => $Value)
			$this->SessionData[$Key] = $Value;
		
		$this->Login($this->SessionData);
	}
	
}

?>
