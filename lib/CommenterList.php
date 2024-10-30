<?php
/*
	Encapsulates information about commenter list

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

include_once('Commenter.php');
include_once('GravatarCommenter.php');
include_once('ItemList.php');
include_once('Database.php');
include_once('WordpressDatabase.php');


class CommenterList extends ItemList
{
	private $size;  //the maximum allowed image width
	private $customDefaultImage; //is custom default image used
	private $limit;
	
	public function  __construct($db,$order='added',$orderDir='desc',$size=0,$customDefaultImage=False,$limit=3)
	{
		parent::__construct($db,$order,$orderDir);
		$this->size = $size;
		$this->limit = $limit;
		$this->loadCommenters();
	}
	

	protected function loadCommenters()
	{
		$sql = "
			SELECT
				comment_post_ID AS postId,
				comment_ID AS commentId, 
				comment_author AS name,
				comment_author_email AS email,
				comment_author_url AS website,
				comment_date_gmt AS date,			
				post_title AS title,
				comment_content AS comment
			FROM 
				{$this->db->prefix()}comments AS c INNER JOIN
				{$this->db->prefix()}posts AS p ON c.comment_post_ID = p.ID
			WHERE 
				comment_approved = '1'  
				AND user_id = '0' 
				AND LENGTH(comment_author_email) > 0 
			 ORDER BY 
				" . (isset($this->order) ? $this->order : 'comment_date_gmt' ) . " " . (isset($this->orderDir) ? $this->orderDir : 'desc' ) . " LIMIT " . (isset($this->limit) ? $this->limit : '5');
		$commenters = $this->db->select($sql);
		
		if(count($commenters))
		{
			foreach($commenters as $commenter)
			{
				$commentURL = get_permalink($commenter->postId)."#comment-{$commenter->commentId}";
				$this->items[] = new GravatarCommenter(
						$commenter->name,
						$commenter->email,
						$commenter->website,
						$commenter->date,
						$commenter->title,
						$commenter->comment,
						$this->size,
						false,
						$commentURL
				);
			}
		}
	}
		
}

?>