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

class Nepama_User
{
	private $UserName;
	private $UserId;
	private $UserData;
	
	public function __construct($Name)
	{
		global $objDb;

		$objDb->Select(array("id", "name", "password"), "users", "WHERE name = '$Name'");
		
		if($objDb->NumRows() == false) return false;
		$x = $objDb->FetchArray();
		
		$this->UserName = $Name;
		$this->UserId = $x['id'];

		$this->UserData = $x;
	}
	
	public function GetId()
	{
		return $this->UserId;
	}
	
	public function GetUserData()
	{
		return $this->UserData;
	}

	public function GetProperty($Prop)
	{
		global $objDb;

		$Property = $objDb->Select($Prop, "users", "WHERE id = '". $this->UserId. "'");
		return $Property;
		
	}	
	
	public function ResetData()
	{
		unset($this->UserData);
	}
	
	public function CheckRight($Right)
	{
		global $objDb;
		
		$GroupId = $this->GetProperty("groupid");
		
		$objDb->Select(array("groupid"), "usergrouprights", "WHERE groupid = '$GroupId' AND (rightname = '$Right' OR rightname = 'can_all')");
		if($objDb->NumRows() == 0) return false;
		else return true;
	}
}

?>
