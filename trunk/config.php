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

if(!defined("MAIN")) exit();

if(function_exists("date_default_timezone_set")) // PHP5.1 =)
	date_default_timezone_set("Europe/London");

define("_VERSION", "0.4.0");
define("_CODENAME", "Saber");

/**
 * 0 - no error output
 * 1 - default error output, except notices
 * 2 - like error_reporting(E_ALL), with 'cutted' backtrace
 * 3 - full error output with complete backtrace
 */
 
$Config = array();
$Config['mysql'] = array("host" => "", "user" => "root", 
						 "pass" => "", "db" => "nepama032",
						 "prefix" => "nep");

?>
