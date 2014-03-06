<?php
/**
 * Plugin Name: Resulter
 * Description: Display examination results.
 * Version: 0.1
 * Author: Gaurav Joseph
 * Author URI: http://about.me/gaurav.joseph
 * License: GPL3
 */
 
 /* Copyright (C) 2014  Gaurav Joseph

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
function resulter_handler($atts){
    extract( shortcode_atts( array(
		'_input_id' => 'none',
	), $atts ) );
	
	if($_input_id=="none"){
	    return "<h1>This user is invalid</h1>You have reached an unintended page. Please use the navigation links for browsing our site.";
	}
}
 
add_shortcode("resulter-show", "resulter_handler");
 
?>
