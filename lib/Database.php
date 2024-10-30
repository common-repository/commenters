<?php
/*
	Encapsulates database handling

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


class Database 
{
	
	protected $db;
	protected $prefix;
	
	
	public function __construct($db)
	{
		$this->db = $db;
	}
		
		
/**
 * Initiates a query
 * 
 * Initiates a query like insert, delete or update, without returning anything
 *
 */
	public function query($sql){ }


/**
 * Initiates a selection query
 * 
 * Initiates a selection query
 *
 * @return a database result in array or objects format
 */
	public function select($sql){ }


/**
 * Initiate a query for a scalar value
 * 
 *
 * 
 * @return a scalara value like string
 */
	public function queryScalar($sql){ }
	
	
/**
 * The last insert ID
 * 
 *
 * 
 * @return a last autoincrement value after the latest insert query
 */
	public function lastInsertId(){ }
	

/**
 * The last insert ID
 * 
 *
 * 
 * @return a last autoincrement value after the latest insert query
 */
	public function prefix()
	{
		return $this->prefix;
	}
	
}

?>