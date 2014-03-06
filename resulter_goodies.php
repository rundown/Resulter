<?php

function selectSubjectByNumber($sno){
	$db = new Resulter_Database(
		get_option('resulter_db_hostname'), 
		get_option('resulter_db_username'), 
		get_option('resulter_db_password'));
	$db->Connect();
	if(!$db->Execute(get_option('resulter_db_database'), "SELECT `subject` FROM `subjects` WHERE `subjectid`='" . $sno . "' LIMIT 1"))
		return "Unknown";
	$rdata = $db->FetchResult();
	return $rdata[0]["subject"];
}

function convertCrapResultsToTables($crapResults){
	$semArray = array();
	$semno = 0;
	$retdata = "<table style=\"width:90%;\">";
	foreach($crapResults as $sem){
		//$tempArray = array();
		$semno = $sem["semester"];
		$retdata .= "<td colspan=\"3\" style=\"padding-left:10px;background:#c0c0c0;\"><h3>Semester: " . $semno . "</h3></td>";
		foreach($sem as $se_k=>$se_v){
			if(substr($se_k, 0, 4)=="acts" && !empty($se_v)){
				//print($se_k . "=" . $se_v . "<br>");
				//$tempArray[selectSubjectByNumber(substr($se_k, 4))] = $se_v;
				$retdata .= "<tr><td style=\"padding-left:10px;\">" . selectSubjectByNumber(substr($se_k, 4)) . "</td>";
				$retdata .= "<td style=\"padding-left:45px\">" . $se_v . "</td>";
				$colAr = (substr($se_v, -1)==="*")? array("#ff0000", "FAIL") : array("#00ff00", "PASS");
				$retdata .= vsprintf("<td style=\"padding-left:15px;text-decoration:small-caps;color:%s\">%s</td>", $colAr);
				$retdata .= "</tr>";
			}
			}
		//$semArray["" . $semno . ""] = $tempArray;
	}
	$retdata .= "</table><br>";
	return $retdata;
}
?>