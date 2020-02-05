<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_user
{
	private $data;
	private $lsvar = 0;
	private $useridarray;
	private $username = '';
	private $userid = '';
	
	public function __construct($row)
	{
		/*
		/	The constructor
		*/
		
		$this->data = $row;
	}
	
	function jakSuperadminaccess($lsvar)
	{
		$useridarray = explode(',', JAK_SUPERADMIN);
		// check if userid exist in db.php
		if (in_array($lsvar, $useridarray)) {
			return true;
		} else {
			return false;
		}
	
	}
	
	function getVar($lsvar)
	{
		
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		return $d[$lsvar];
		
	}
}
?>