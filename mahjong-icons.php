<?php
/*
Plugin Name: Mahjong Icons
Plugin URI: http://wordpress.org/extend/plugins/mahjong-icons/
Description: Replace mahjong tile expressions in your posts or comments to the mahjong tile icons. 
Version: 1.0
Author: Kei Saito
Author URI: http://ksnn.com/diary/
*/

/*  Copyright 2009 Kei Saito (email : kei.saito@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/*

 This filter plugin replaces mahjong tile expressions in the
 contents and comments into mahjong tile images. 

 Supported expressions are following:
 [1p], [2p], ...[9p] : 1-9 dots (pin-zu)
 [1s], [2s], ...[9s] : 1-9 bamboos (so-zu)
 [1m], [2m], ...[9m] : 1-9 characters (man-zu)
 [5pr], [5sr], [5mr] : red 5's (aka-wo)
 [ton]               : East  (ton)
 [nan]               : South (nan)
 [sha]               : West  (sha)
 [pei]               : North (pei)
 [hak]               : White (haku)
 [hat]               : Green (hatsu)
 [chu]               : Red   (chun)
 [ura]               : Backside (ura)

 Adding 'l'(landscape) after each expression shows the 90-degree-rotated image.
 For example, [1pl] shows rotated [1p] image. 

 You can escape the expression by adding another braces
 like [[1p]]. 

 All images are the copyright-free and are from : 
 http://www4.cty-net.ne.jp/~l6000all/haigapage.htm
*/

function filter_mahjong_tile_expressions($content) {

  // Handling escapes. Temporariry renaming [[xx]] to ___xx___.
  $pattern = '/\[{2}(\d(m|p|s)r{0,1}l{0,1})\]{2}/';
  $replacement = '___${1}___';
  $content = preg_replace($pattern, $replacement, $content);

  $pattern = '/\[{2}((ton|nan|sha|pei|hak|hat|chu|ura)l{0,1})\]{2}/';
  $replacement = '___${1}___';
  $content = preg_replace($pattern, $replacement, $content);

  // Replace number tile expressions to number tile icons.
  $pattern = '/\[(\d(m|p|s)r{0,1}l{0,1})\]/';
  $replacement = '<img src="wp-content/plugins/mahjong-icons/images/${1}.gif"/>';
  $content = preg_replace($pattern, $replacement, $content);

  // Replace character tile expressions to character tile icons.
  $pattern = '/\[((ton|nan|sha|pei|hak|hat|chu|ura)l{0,1})]/';
  $replacement = '<img src="wp-content/plugins/mahjong-icons/images/${1}.gif"/>';
  $content = preg_replace($pattern, $replacement, $content);

  // Handling escapes. Getting back ___xx___ expressions to [xx].
  $pattern = '/___(\d(m|p|s)r{0,1}l{0,1})___/';
  $replacement = '[${1}]';
  $content = preg_replace($pattern, $replacement, $content);

  $pattern = '/___((ton|nan|sha|pei|hak|hat|chu|ura)l{0,1})___/';
  $replacement = '[${1}]';
  $content = preg_replace($pattern, $replacement, $content);

  return $content;
}
add_filter('the_content', 'filter_mahjong_tile_expressions');
add_filter('comment_text', 'filter_mahjong_tile_expressions');
?>