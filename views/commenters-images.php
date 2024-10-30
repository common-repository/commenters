<?php
/*
	Implements the image view

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

<?php 
	echo $before_widget.(strlen($this->title) ? $before_title.$this->title.$after_title : '');
?>
	<div id="commenters-widget-commenters">
		<div id="navi">
			<div id="prev"><<</div><div id="next">>></div>
		</div>
		<div class="commenters-clear"></div>
		<?php
			if(count($commenters))
			{
				?>
				<ul id="pages" style="margin:0px;padding:0px;">
					<?php
						$perPage = isset($this->perPage) && strlen($this->perPage) ? $this->perPage : 1;
						$pagingCount = 1;
						$amount = count($commenters);
						$lastPage = ceil($amount/$perPage);
						$displayedPageCount = 0;
						
						foreach($commenters as $commenter)
						{
							?>
							<li style="padding:0px;margin:0px;">
								<?php 
									?>
									<a title="<h3 class='commentHeader'><?php echo $commenter->title() ?></h3><b><?php echo $commenter->name() ?>:</b> <span class='commentText'><?php echo $commenter->comment() ?></span>" class="commenter" target="_blank" href="<?php echo strlen($commenter->website()) ? $commenter->website() : 'javascript:void(0)'; ?>"><img src="<?php echo $commenter->imageUrl() ?>" style="width:<?php echo $commenter->size() ?>px;height:<?php echo $commenter->size() ?>px;"  /></a>
									<a href="<?php echo $commenter->commentURL() ?>"><span class="commentLink"></span></a>
							</li>
							<?
						}
					?>
				</ul>
				<?php
			}
		?>
	</div>
<?php include_once('_slider-css.php') ?>
<?php include_once('_slider.php') ?>
<?php
	echo $after_widget;
?>