<?php
/*
	Encapsulates information about a commenter

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

class Commenter
{
	protected $id;
	protected $name;
	protected $email;
	protected $website;
	protected $date;
	protected $title;
	protected $comment;
	
	
	public function __construct($name,$email,$website,$date,$title,$comment)
	{
		$this->name = $name;
		$this->email = $email;
		$this->website = $website;
		$this->date = $date;
		$this->title = $title;
		$this->comment = $comment;
	}
	
	
/*
	Getters
*/
	public function name()
	{
		return $this->name;
	}

	public function email()
	{
		return $this->email;
	}

	public function website()
	{
		return $this->website;
	}

	public function date()
	{
		return $this->date;
	}
	
	public function title()
	{
		return $this->title;
	}
		
	public function comment()
	{
		return $this->comment;
	}
	
}

?>