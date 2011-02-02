<?php
/*
Plugin Name: Dream Variables
Plugin URI: http://www.iantearle.com/
Description: Provides dream_add_variable() for plugins to write to templates.
Author: Ian Tearle
Version: 1.0
Author URI: http://www.iantearle.com/
*/


	function dream_add_variable($arg, $area = 'main', $loop = '')
	{
		global $user_vars;
		$var = dream_parse_strr($arg, false);
		if (!empty($loop)) {
		  $user_vars[$area][$loop] = isset($user_vars[$area][$loop]) 
		  							? array_merge($user_vars[$area][$loop],$var)
									: $var;
		} 
		else 
		{
			$user_vars[$area] = isset($user_vars[$area]) 
								?  array_merge($user_vars[$area],$var)
								: $var;
		}
	}
	
	function dream_parse_strr($arg, $tolower = true)
	{
		$arg = explode('|', $arg);
		$arr = array();
		foreach ($arg as $val) {
		  $narg = explode(':', $val);
		  $narg[0] = strtolower($narg[0]);
		  if (!in_array($narg[0], array('template', 'category', 'subcategory')) && $tolower) {
		      $narg[1] = strtolower($narg[1]);
		  }
		  $arr[$narg[0]] = dream_unsafe_tpl($narg[1]);
		}
		unset($narg);
		return $arr;
	}
	
	function dream_unsafe_tpl($str)
	{
		return str_replace('\x3a', ':', $str);
	}  

?>
