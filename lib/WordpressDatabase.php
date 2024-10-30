<?php
/*
	Encapsulates database handling for Wordpress usage

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


class WordpressDatabase extends Database
{
	
	public function __construct($db)
	{
		$this->prefix = $db->prefix;
		parent::__construct($db);
	}
	
	
	public function query($sql)
	{
		ob_start();
		$this->db->show_errors();
		$this->db->query($this->db->prepare($sql));
		$errors = ob_get_clean();
		$this->db->hide_errors();
		
		if(strlen($errors))
		{
			throw new Exception(' (WordpressDatabase,query) Error in query: '.$errors);
		}		
	}
	
	
	public function select($sql)
	{
		ob_start();
		$this->db->show_errors();
		$results = $this->db->get_results($this->db->prepare($sql));
		$errors = ob_get_clean();
		$this->db->hide_errors();
		
		if(strlen($errors))
		{
			throw new Exception(' (WordpressDatabase,select) Error in query: '.$errors);
		}
		
		return $results;
	}
	
	
	public function selectScalar($sql)
	{
		ob_start();
		$this->db->show_errors();
		$result = $this->db->get_var($this->db->prepare($sql));
		$errors = ob_get_clean();
		$this->db->hide_errors();
		
		if(strlen($errors))
		{
			throw new Exception(' (WordpressDatabase,selectScalar) Error in query: '.$errors);
		}
		
		return $result;	
	}
	
	
	public function lastInsertId()
	{ 
		return $this->db->insert_id;
	}
		
	
}


?>