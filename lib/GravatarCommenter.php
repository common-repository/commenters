<?php
/*
	Encapsulates information about a Gravatar commenter

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

class GravatarCommenter extends Commenter 
{
	private $imageUrl;
	private $size; //Avatars are square
	private $customDefaultImage;
	private $commentURL;

	
	public function __construct($name,$email,$website,$date,$title,$comment,$size=0,$customDefaultImage=false,$commentURL)
	{
		parent::__construct($name,$email,$website,$date,$title,$comment);
		$this->size = $size;
		$this->customDefaultImage = $customDefaultImage;
		$this->commentURL = $commentURL;
		$this->generateImageUrl();
	}
	
	
/*
 * Downloads image from Gravatar
 * 
 * Gets image from Gravatar or sets image as empty if not image is found
 */
	private function generateImageUrl()
	{
		$this->imageUrl  = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email)))."?s={$this->size}&d=mm&r=g";
		if($this->customDefaultImage)
		{
			$this->imageUrl .= "&d=".urlencode($this->customDefaultImage);
		}
	}
	
	
/*
 * Getters
 *
 */
	public function imageUrl()
	{
		return $this->imageUrl;
	}
	
	public function size()
	{
		return $this->size;
	}
	
	public function commentURL()
	{
		return $this->commentURL;
	}
	
}

?>