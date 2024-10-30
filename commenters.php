<?php
/*
Plugin Name: Commenters
Plugin URI: http://www.svenkauber.com/projects/commenters
Description: Commenters lets you show the latest comments to your blog by showing images of commenters from Gravatar.
Version: 1.0
Author: Sven Kauber
Author URI: http://www.svenkauber.com
License: GPL3


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


include_once('lib/Widget.php');


class Commenters extends Widget
{


	public function __construct($id,$pluginName,$className,$title,$description,$nonceName) 
	{
		
		parent::__construct($id,$pluginName,$className,$title,$description,$nonceName);

		//including the needed classes
		include_once($this->wpPluginDir."/{$this->pluginName}/lib/CommenterList.php");
	}
	
	
	public function init()
	{
		$msgs = array(
			'Commenters requires WordPress 2.5 or newer.
			<a target="_blank" href="http://codex.wordpress.org/Upgrading_WordPress">Please 
			update!</a>',
			'Commenters requres at least PHP 5.0'
		);
		
		global $wp_version;
		
		if(version_compare($wp_version,"2.5","<") || 
		  !function_exists('wp_register_sidebar_widget') || 
		  !function_exists('register_widget_control'))
		{
			throw new Exception($msgs[0]);
		}

		$version = explode('.', phpversion());
		
		if($version[0] < 5)
		{
			throw new Exception($msgs[1]);
		}

		parent::init();
	}
	
	
	public function widget($args)
	{
		$commenters = false;
		
		if(!is_admin())
		{
			try 
			{	
				//$this->... are coming from the parend class initializer
				$cl = new CommenterList(
					new WordpressDatabase($this->db),
					$this->order,
					$this->orderDir,
					$this->size,
					$this->customDefaultImage,
					$this->limit);
				$commenters = $cl->getItems();
			}
			catch (Exception $e)
			{
				 echo 'Error: ',  $e->getMessage(), "\n";
			}

			parent::widget($args);

			if(count($commenters))
			{
				include_once("{$this->wpPluginDir}/{$this->pluginName}/views/{$this->pluginName}-images.php");
			}
		}
	}
	
	
	public function initScripts()
	{
	    wp_enqueue_script('jquery'); 
	    wp_enqueue_script('plugins', $this->wpPluginUrl.'/'.$this->pluginName.'/js/plugins.js', array('jquery')); 
	}	


	public function install() 
	{
	    add_option($this->pluginName, array('title' => 'Latest commenters', 'limit' => '3', 'perPage' => '1', 'order' => 'comment_date', 'orderDir' => 'desc', 'scrollDirection' => 'left', 'width' => '120', 'height' => '120', 'size' => '120', 'posX' => '3', 'posY' => '8'));
		parent::install();
	}
	
}


$widget = new Commenters(
	'commenters',
	'Commenters',
	'Commenters',
	'Commenters',
	'Images of latest commenters from Gravatar',
	'commenters_nonce'
);

?>