<?php
/*
	This file acts as an uninstaller for the plugin

	Copyright 2010  SVEN KAUBER  (email : sven@svenkauber.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 3, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

if(!defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN'))
    exit();

//deleting options
delete_option('commenters');


?>