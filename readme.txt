=== Commenters ===

Contributors: 5ven
Donate link: http://www.svenkauber.com/projects/commenters
Tags: media, jquery, images, gallery, comment
Requires at least: 2.5
Tested up to: 3.0.1
Stable tag: trunk

Commenters lets you display images of persons who added comments to your blog posts.


== Description ==

Your commenters displayed in the spotlight! After you have accepted comments, images of the commenters will be displayed in a nice sliding gallery view.

Commenters has following functions:

* images are displayed from Gravatar
* measures of the gallery area may be easily changed
* image size may be changed
* amount of images shown per one carousel page may be set
* images may be ordered by commenters or by blog post title, using either ascending or descending order
* there's link at the bottom-right corner that will take visitor to the page where comment is situated in the blog
* commenter's avatar image is a link that takes to to commenter's website 
* post title, commenter name (if given) and content of the comment are shown in a tooltip that appears when visitor moves mouse cursor over the avatar image


== Installation ==

1. Upload the whole plugin folder to your /wp-content/plugins folder.
2. Go to the 'Plugins' page in the administrative menu and activate the plugin.
3. Go to the 'Widgets' page and drag the 'Commenters' to a widget area.
4. Default settings are already filled in and make corrections as needed.
5. Set a title for the widget or leave empty.
6. 'Limit' allows to limit the amount of newest comments shown. It is useful to set a value like 10 or 20 here so that the slidable element does not become too large because sliding might become slow.
7. On the 'Per page' field enter the amount of images that you would like to be displayed on one carousel paging page.
8. 'Order by' lets you define how images are ordered: by comment date, e-mail or by blog post title and in ascending or descending order.
9. 'Direction' lets you to define to what direction the sliding happens: either vertically or horizontally.
10. In the 'Width' set width for the widget.
11. 'Height' allows height to be set for the widget. 
12. Use 'Size' to define the outer measures of the widget. Avatar images are squares and one value is enough. Try to experiment to see what fits into your theme.
13. 'C.link (X)' is to set the horizontal position of the magnifying glass relative to the bottom-right corner. The magnifying glass is used for a link to take the user to the page where the comment is located. Insert a value in pixels in here.
14. Insert a value in pixels to 'C.link (Y)' to vertically align the magnifying glass in relation to the bottom-right corner.


== Screenshots ==

1. Administration view
2. Gallery view with the mouseover tooltip


== Changelog ==

= 1.0 =
* The initial version


== Credits ==

Thanks to:

[Fred Heusschen](http://www.frebsite.nl/home/) for his [carouFredSel plugin for jQuery](http://caroufredsel.frebsite.nl/), used in this widget for the carousel functionality

Jörn Zaefferer for his [tooltip plugin](http://bassistance.de/jquery-plugins/jquery-plugin-tooltip/) for jQuery for showing post titles and comments

[Brandon Aaron](http://brandonaaron.net) for the big IE frame plugin for jQuery

The magnifying glass image is from [FunDraw.com](http://www.fundraw.com/clipart/clip-art/1656/Magnifying-Glass/#usebuy)


== Tips ==

Requirements:
* For sliding images, at least jQuery 1.3.2 must be installed. You can copy the right one from wp-content/plugins/commenters/js over to wp-includes/js

Configuring the sliding widget to fit into your theme:
The files that may need to be modified are wp-content/plugins/commenters/views/_slider-css.php and commenters-images.php .


== License ==

This file is part of Commenters. 

Commenters is free software: you can redistribute it and/or modify  
	it under the terms of the GNU General Public License as published  
   	by the Free Software Foundation, either version 3 of the License,  
   	or (at your option) any later version. 
Commenters is distributed in the hope that it will be useful,  
   	but WITHOUT ANY WARRANTY; without even the implied warranty of  
   	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU  
   	General Public License for more details. 
You should have received a copy of the GNU General Public License  
	along with Commenters. If not, see [the license](http://www.gnu.org/licenses/).