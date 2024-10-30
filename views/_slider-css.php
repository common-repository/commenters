<?php
/*
	Partial that implements the slider styles

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
?>

<style type="text/css">
/*
	Needed to avoid setting height of divs in order to set background color
*/
.commenters-clear {
	clear:both;
	height:1px;
	overflow:hidden;
}

/*
	For the Front-end
*/
#commenters-widget-commenters {
		margin-left:auto;
		margin-right:auto;
		width: <?php echo strlen($this->width) ? $this->width   : '100' ?>px;
		height:<?php echo strlen($this->height) ? $this->height : '100' ?>px;
		clear:both;
	}
	
	#commenters-widget-commenters #pages {
		margin-left:0px;
		padding-left:0px;
		*margin-left:-25px; /* for IE6 and 7, IE8 does not need this*/
	}
	#commenters-widget-commenters #navi {
		display:table;
		width:100%;
		}
		#commenters-widget-commenters #navi #prev  {
			height:20px;
			width:20px;
			float:left;
			cursor:pointer;
			cursor:hand;
			float:left;
		}
		#commenters-widget-commenters #navi #next  {
			height:20px;
			width:20px;
			cursor:pointer;
			cursor:hand;
			float:right;
		}
	#commenters-widget-commenters ul {
		list-style:none;
		}
		#commenters-widget-commenters ul li {
			float:left;
			position:relative;
		}
.commenters-widget-title {
}
.commenters-widget-see-comment {
	float:left;
	text-align:right;
	width:20px;
}
.image {
	display:table-row;
	clear:both;
}
.image a {
	clear:both;
	border:0px;
}
a.title {
	text-decoration:none;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
a.title:hover {
	text-decoration:none;
}
.commentLink {
	position:absolute;
	height:35px;
	width:25px;
	background: url(<?php echo $this->wpPluginUrl.'/'.$this->pluginName ?>/img/magnifying-glass.png) 4px 4px no-repeat;
	_background: url(<?php echo $this->wpPluginUrl.'/'.$this->pluginName ?>/img/magnifying-glass.gif) 4px 4px no-repeat; /* for IE 6*/
	bottom:<?php echo strlen($this->posY) ? $this->posY : '0'  ?>px;
	right:<?php echo strlen($this->posX) ? $this->posX : '0'  ?>px;
	}
.caroufredsel_wrapper ul li {
	margin:0px;
	padding:0px;
}


/*
 * For tooltip
 */
#tooltip {
	position: absolute;
	z-index: 3000;
	border: 1px solid #111;
	background-color: #eee;
	padding: 5px;
	opacity: 0.85;
	text-align:left;
	width:<?php echo strlen($commenter->size()) && $commenter->size() > 200 ? $commenter->size() : '200' ?>px;
}
#tooltip h3, #tooltip div { margin: 0; }
.commentHeader {
	font-weight:bold;
	font-size:14px;
}
.commentText {
	font-size:13px;
}
</style>