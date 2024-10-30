<?php
/*
	Partial that implements the slider

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

<script type="text/javascript">
jQuery(document).ready(function() {


	jQuery('a.commenter').tooltip({
		track: true, 
	    delay: 0, 
	    showURL: false,
		fade: 250
	});

	
	jQuery("#commenters-widget-commenters ul#pages").carouFredSel({
		width: <?php echo $this->size ?>,
		height: <?php echo $this->size ?>,
		direction : "<?php echo $this->scrollDirection ?>",
		items: {
			visible: <?php echo $this->perPage ?>,
			height: "variable"
		},
		auto: false,
		prev: {
			button: "#prev",
			key: 37
		},
		next: {
			button: "#next",
			key: 39
		}
	});

	
	
	
});
</script>