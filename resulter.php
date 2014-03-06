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

require("resulter_db_class.php");
require("resulter_options.php");
require("resulter_goodies.php");


function resulter_handler($atts){
	$query_string_rs_user = "SELECT * FROM `students` WHERE `regn`='%s' LIMIT 1";
	$query_string_rs_resl = "SELECT * FROM `batchresult%s` WHERE `studentid`='%s' ORDER BY `semester`";
	ob_start();
	echo('<div><form method="POST" action="' . $_SERVER['REQUEST_URI'] . '">');
	echo('<input type="text" name="input-id"><input type="submit">');
	echo('</form></div>');

	if(!isset($_POST["input-id"])){ return ob_get_clean(); }
	if((!empty($_POST["input-id"])) && preg_match("/[ptPT][0-9]+\/[0-9]+/", $_POST["input-id"], $matches)){
	        $db = new Resulter_Database(
	        	get_option('resulter_db_hostname'),
		        get_option('resulter_db_username'),
		        get_option('resulter_db_password'));
	        if($db->Connect()){
		        if(!$db->Execute(
		        	get_option('resulter_db_database'),
		        	sprintf(query_string_rs_user, $db->SanitizeString($matches[0])))){
				echo("We are having some trouble, please try later!");
		        	return ob_get_clean();
		        }
		        $res = $db->FetchResult();
		        if(empty($res[0]["name"])){
		        	echo("There are no entries by this name");
		        	return ob_get_clean();
		        }
		        $student = new stdClass();
		        $student->details = $res[0];
		        $db->Execute(get_option('resulter_db_hostname'), sprintf(query_string_rs_resl, $res[0]["year"], $res[0]["studentid"]));
		        $student->results = $db->FetchResult();
		        //return $student;
		        echo('<h2>Student Details</h2>');
			echo('<table>');
			echo('<tr>');
			echo('	<td rowspan="4" style="padding:0;padding-right: 15px;">');
			echo('		<img src="/app/data/images/students/' . str_replace("/", "-", $student->details["regn"]) . '.jpg" alt="' . $student->details["name"] . '" title="' . $student->details["name"] . '">');
			echo('	</td>');
			echo('	<td>Name:</td><td style="padding-left:15px;">' . $student->details["name"] . '</td>');
			echo('</tr>');
			echo('<tr>');
			echo('	<td>Congregation:</td><td style="padding-left:15px;">' . $student->details["congregation"] . '</td>');
			echo('</tr>');
			echo('<tr>');
			echo('	<td>Section:</td>');
			echo('	<td style="padding-left:15px;">' . ($student->details["section"]=="P")?"Philosophy":"Theology" . '</td>');
			echo('</tr>');
			echo('<tr>');
			echo('	<td>Register No.:</td><td style="padding-left:15px;">' . $student->details["regn"] . '</td>');
			echo('</tr>');
			echo('</table><br>');
			echo('<h2>Results</h2>');
			if($student->results)
				echo(convertCrapResultsToTables($student->results));
			else
				echo("Sorry! No results available at this time");
		}else
			echo("We are having some database problems. Come by us again later.");
	}else{
		echo("Please enter the user id in the form: <strong>P12/208</strong>");
	}
	return ob_get_clean();

} //end_main
 
add_shortcode("resulter-show", "resulter_handler");

?>