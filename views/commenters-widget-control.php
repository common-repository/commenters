<?php
/*
	Implements the administration view

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

<div id="commenters-settings">
	<div class="config-option">
		<span>Title:</span>
		<input name="commenters[title]" class="text" type="text" value="<?php echo $this->title; ?>" />
	</div>
	<div class="config-option">
		<span>Limit:</span>
		<input name="commenters[limit]" class="text" type="text" value="<?php echo $this->limit; ?>" />
	</div>
	<div class="config-option">
		<span>Per page:</span>
		<input name="commenters[perPage]" class="text" type="text" value="<?php echo $this->perPage; ?>" />
	</div>
	<div class="config-option">
		<span>Order by:</span>
		<select name="commenters[order]" id="commenters_order_by"  class="dropdown-order">
			<option value="comment_date" <?php echo $this->order==='comment_date' ? 'selected="yes"' : '' ?>>
				comment date
			</option>
			<option value="comment_author_email" <?php echo $this->order==='comment_author_email' ? 'selected="yes"' : '' ?>>
				e-mail
			</option>
			<option value="post_title" <?php echo $this->order==='post_title' ? 'selected="yes"' : '' ?>>
				post title
			</option>
		</select>
		<select name="commenters[orderDir]" id="commenters_order_dir" class="dropdown-order">
			<option value="asc" <?php echo $this->orderDir==='asc' ? 'selected="yes"' : '' ?>>
				asc
			</option>
			<option value="desc" <?php echo $this->orderDir==='desc' ? 'selected="yes"' : '' ?>>
				desc
			</option>
		</select>
	</div>
	<div class="config-option">
		<span>Direction:</span>
		<select name="commenters[scrollDirection]" id="commenters_scroll_direction" class="drop-down-scrolldirection">
			<option value="left" <?php echo $this->scrollDirection==='left' ? 'selected="yes"' : '' ?>>
				horizontal
			</option>
			<option value="up" <?php echo $this->scrollDirection==='up' ? 'selected="yes"' : '' ?>>
				vertical
			</option>
		</select>
	</div>
	<div class="config-option">
		<span>Width:</span>
		<input type="text" name="commenters[width]" class="text" value="<?php echo $this->width ?>" />
	</div>
	<div class="config-option">
		<span>Height:</span>
		<input type="text" name="commenters[height]" class="text" value="<?php echo $this->height ?>" />
	</div>
	<div class="config-option">
		<span>Size:</span>
		<input type="text" name="commenters[size]" class="text" value="<?php echo $this->size ?>" />
	</div>
	<div class="config-option">
		<span>C.link (X):</span>
		<input type="text" name="commenters[posX]" class="text" value="<?php echo $this->posX ?>" />
	</div>
	<div class="config-option">
		<span>C.link (Y):</span>
		<input type="text" name="commenters[posY]" class="text" value="<?php echo $this->posY ?>" />
	</div>
	<input type="hidden" id="commenters_submit" name="commenters_submit" value="1" /> 
	<?php wp_nonce_field("options",$this->nonceName); ?>
</div>

<style type="text/css">
#commenters-settings {
	border:0px;
	margin:0px;
	padding:0px;
	}
	#commenters-settings div.config-option {
		width:250px;
		font-size:11px;
	}
	#commenters-settings div.config-option span {
		width:70px;
		display:block;
		float:left;
		font-size:11px;
	}
	.drop-down-scrolldirection {
		width:150px;
	}
	.drop-down-resizeby {
		width:150px;
	}
	#commenters-settings div.config-option input.text {
		width:150px;
	}
</style>