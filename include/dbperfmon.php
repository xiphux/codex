<?php
/*
 *  dbperfmon.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: dbperfmon
 *  Display adodb performance monitoring
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function dbperfmon()
{
	global $db;
	session_start();
	$perf =& NewPerfMonitor($db);
	$perf->UI($pollsecs=5);
}
 
?>
