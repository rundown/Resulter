<?php
class Database{
				private static $o_link;
				private $s_host, $s_un, $s_pw;
				private $s_err, $o_array, $o_result;
				
				function __construct($s_h, $s_u, $s_p){
								$this->s_host = $s_h;
								$this->s_un = $s_u;
								$this->s_pw = $s_p;
				}
				public function Error(){
								return $this->s_err;
				}
				public function Connect(){
								if(!self::$o_link){
												self::$o_link = mysql_connect($this->s_host, $this->s_un, $this->s_pw);
												if(!self::$o_link){
																$this->s_err = "The server could not connect to the database.";
																return false;
												}else{
																$this->s_err = "";
																return true;
												}
								}
								return true;
				}
				public function SanitizeString($inString){
								return mysql_real_escape_string($inString, self::$o_link);
				}
				public function Execute($s_dbname, $query){
								mysql_select_db($s_dbname, self::$o_link);
								$result = mysql_query($query, self::$o_link);
								if(!$result){
												$this->s_err = "Query execution failed.";
												return false;
								}else{
												$this->o_result = $result;
												return true;
								}
				}
				public function FetchResult(){
								$this->o_array = array();
								if(mysql_num_rows($this->o_result) == 0) return false;
								mysql_data_seek($this->o_result, 0);
								while ($row = mysql_fetch_array($this->o_result,MYSQL_ASSOC)){
												array_push($this->o_array, $row);
								}
								return $this->o_array;
				}
				public function Disconnect(){
								mysql_close(self::$o_link);
        self::$o_link = false;
				}
				function __destruct(){
								$this->Disconnect();
				}
}

?>
