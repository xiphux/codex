<?php
/*
 *  listfics_title.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_title
 *  List fics by title
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
include_once('defs.php');
include_once('highlight.php');
include_once('printfic.php');

function listfics_title($highlight = 0, $searchstring = null)
{
	global $tables;

	$fl = DBGetCol("SELECT fic_id FROM " . $tables['fics'] . " ORDER BY fic_title");
	foreach ($fl as $row)
		printfic($row,TRUE,$highlight,$searchstring);
}

?>
