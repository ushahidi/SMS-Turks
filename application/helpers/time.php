<?php

class time {

	public static function db_timestamp($unix_ts=NULL){
		if($unix_ts === NULL) $unix_ts = time();
		return gmdate("Y-m-d H:i:s", $unix_ts);
	}

}