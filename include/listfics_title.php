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
	global $tables, $cache;

	$outkey = "output_listfics_title_" . $highlight . "_" . md5($searchstring);

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";
		$fl = $cache->Get("listfics_title");
		if (!$fl) {
			$fl = DBGetCol("SELECT id FROM " . $tables['fics'] . " ORDER BY title");
			$cache->Set("listfics_title", $fl);
		}
		foreach ($fl as $row)
			$out .= printfic($row,TRUE,$highlight,$searchstring);
		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
