<?php

class Widget 
{
	protected $id;
	protected $pluginName;
	protected $className;
	protected $title;
	protected $description;
	protected $nonceName;
	protected $db;
	protected $wpContentUrl;
	protected $wpContentDir;
	protected $wpPluginUrl;
	protected $wpmuPluginDir;
	protected $options;
	

	public function __construct($id,$pluginName,$className,$title,$description,$nonceName) 
	{
		global $wpdb;
		$this->db = &$wpdb;
		$this->id = $id;
		$this->className = $className;
		$this->description = $description;
		$this->nonceName = $nonceName;
		
		//http://codex.wordpress.org/Determining_Plugin_and_Content_Directories
		if(version_compare(get_bloginfo('version'), '3.0', '<') && $this->isSSL()) 
		{
			$this->wpContentUrl = str_replace('http://', 'https://', get_option('siteurl'));
		} 
		else 
		{
			$this->wpContentUrl = get_option('siteurl');
		}	
		$this->wpContentUrl .= '/wp-content';
		$this->wpContentDir = ABSPATH . 'wp-content';
		$this->wpPluginUrl = $this->wpContentUrl . '/plugins';
		$this->wpPluginDir = $this->wpContentDir . '/plugins';
		$this->wpmuPluginUrl = $this->wpContentUrl . '/mu-plugins';
		$this->wpmuPluginDir = $this->wpContentUrl . '/mu-plugins';
		$this->pluginName = strtolower($pluginName);
		
		$this->getOptions();

		
		add_action('widgets_init', array(&$this, 'init'));

		register_activation_hook($this->wpPluginDir.'/'.$this->pluginName.'/'.$this->pluginName.'.php',array(&$this, 'install'));
		
		!is_admin() ? add_action('wp_print_scripts', array(&$this,'initScripts')) : '';


		/*
		if(is_admin())
		{
			if(function_exists('register_uninstall_hook'))
			{
				register_uninstall_hook(__FILE__, array(&$this,'uninstall'));
			}
		}
		*/
		
	}


	public function init()
	{
		$widgetOptions = array(
			'classname' => $this->pluginName,
			'description' => $this->description,
		);
		wp_register_sidebar_widget($this->id,ucfirst($this->pluginName),array(&$this,'widget'),$widgetOptions);

		register_widget_control($this->id, array(&$this,'options'));
		
	}
	
	
	public function widget($args) 
	{
		extract($args); //getting $before_widget, $before_title, $after_title and $after_widget
	}


	public function options()
	{
		//handle user input 
	    if($_POST[$this->id."_submit"])
	    {
			if(wp_verify_nonce($_POST[$this->nonceName],'options'))
			{
				$this->saveOptions();
			}
	    }
		
		/*
		//admin side
		try
		{
			//handling the possible POST request here if needed
		}
		catch (Exception $e)
		{
		 	echo 'Error: ',  $e->getMessage(), "\n";
		}
		*/
		
		//print out the widget control
	    
		require($this->wpPluginDir."/{$this->pluginName}/views/".$this->id."-widget-control.php");		
	}


	private function getOptions()
	{
		$this->options = get_option($this->pluginName);
		
		if(is_array($this->options) && count($this->options))
		{
			foreach($this->options as $id => $val)
			{
				$this->{$id} = $val;
			}
		}
	}


	private function saveOptions()
	{
		$this->options = $_POST[$this->pluginName];
		
		if(is_array($this->options) && count($this->options))
		{
			foreach($this->options as $id => $val)
			{
				$val = strip_tags(stripslashes($val));
				$this->options[$id] = $val;
				$this->{$id} = $val;
			}
		}
	 	update_option($this->pluginName, $this->options);
	}


	function isSSL() 
	{
		if(isset($_SERVER['HTTPS'])) 
		{
			if('on' == strtolower($_SERVER['HTTPS']))
			{
	 			return true;
			}
			if('1' == $_SERVER['HTTPS'])
	 			return true;
		} 
		elseif (isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'])) 
		{
			return true;
		}
		return false;
	}
	

	public function initScripts()
	{
		/*
	    wp_enqueue_script('jquery'); 
	    wp_enqueue_script('carou_fred_sel_script', $this->wpPluginUrl.'/'.$this->pluginName.'/js/jquery.carouFredSel.js', array('jquery')); 
		*/
	}



	public function install() 
	{
		/*
	   	$tables = array(
			0 => $this->db->prefix . "{$this->id}_name1",
			1 => $this->db->prefix . "{$this->id}_name2",
		);

		$sqls = array(
			$tables[0] => "CREATE TABLE IF NOT EXISTS `".$tables[0]."` (
		  		`id` int(11) NOT NULL AUTO_INCREMENT,
		  		`title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
		  		PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;",
			$tables[1] => "CREATE TABLE IF NOT EXISTS `".$tables[1]."` (
		  		`name1_id` int(11) NOT NULL,
		  		`name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
		  		PRIMARY KEY (`vote_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;",
		);

		foreach($sqls as $table => $sql)
		{
			if($this->db->get_var("SHOW TABLES LIKE '$table'") != $table)
			{
				include_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
			}
		}

		add_option("{$this->id}_db_version", THEDBVERSION); //assuming that there is a constant defined
		*/
	}



}

?>