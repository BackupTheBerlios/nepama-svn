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

error_reporting(E_ALL);
session_start();

if(!defined("MAIN")) exit();
define("_PATH", str_replace("\\", "/", getcwd()) ."/");

/** DEVELOPERS NOTE
 * config.local.php consists of some user-defined variables like 
 * the mysql connection data etc. - this file is not overwritten
 * during an update.
*/
require(_PATH . "config.php");
if(file_exists(_PATH . "config.local.php")) require(_PATH . "config.local.php");

require(_PATH ."/library/lib.php");

/** DEVELOPERS NOTE
 * load and set the errorhandler.
*/
require(_PATH . "library/nepama_errorhandler.php");
set_error_handler("Nepama_ErrorHandler");

/** DEVELOPERS NOTE
 * load and configure mysql connection
*/
require(_PATH . "library/andylib_mysql.php");
$objDb = new andylib_MySQL($Config['mysql']['host'], $Config['mysql']['user'], $Config['mysql']['pass'], $Config['mysql']['db'], $Config['mysql']['prefix']);
$objDb->Connect();

/** DEVELOPERS NOTE
 * load and configure smarty template engine
*/
define("SMARTY_DIR", _PATH . "library/smarty/");
require(SMARTY_DIR ."Smarty.class.php");
require(_PATH . "library/andylib_smarty.php");

$objTpl = new andylib_Smarty;

$objTpl->template_dir = _PATH . "templates/";
$objTpl->compile_dir  = _PATH . "templates_c/";
$objTpl->config_dir   = _PATH . "templates/";
$objTpl->cache_dir    = _PATH . "templates_cache/";

/** DEVELOPERS NOTE
 * include some nepama classes
*/
require(_PATH . "library/nepama_session.php");
require(_PATH . "library/nepama_user.php");
$objSession = new Nepama_Session();

require(_PATH . "library/nepama_module.php");

?>