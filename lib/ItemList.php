<?php
/*
	Encapsulates information about a list

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

class ItemList
{
	
	protected $items; //array having all the items
	protected $db; //the database object that can be queried to get the existing items from the database
	protected $order; //the list will be ordered by this text
	protected $orderDir; //the order direction (asc/desc)
	

	/*
		$db: reference to database, needed to fetch the movies
		$url: may be left empty, the url from where to download the movie listing
	*/
	public function __construct($db,$order='title',$orderDir='asc')
	{
		$this->items = array();
		$this->db = $db;
		$this->order = $order;
		$this->orderDir = $orderDir;
	}
	
	
/**
 * Check if item exists
 * 
 * Checks if the given title exists among the loaded items.
 *
 * @param string $title The title that needs to be searched
 */
	protected function itemExists($title)
	{
		if(isset($this->items) && count($this->items))
		{
			foreach($this->items as $item)
			{
				if($movie->title === $title)
				{
					return true;
				}
			}
			return false;
		}
		else
		{
			return false;
		}
	}


/**
 * Gets items
 * 
 * Gets all the loaded item information for the caller.
 *
 */
	public function getItems()
	{
		return $this->items;
	}


/**
 * Saves items to database
 * 
 * Saves all the information about items to database.
 *
 */
	protected function saveItems(){ }

	
/**
 * Load items from the database
 * 
 * Load all items from the database and also their related images.
 *
 */
	protected function loadItems(){ }
			
}

?>