<?php
/*
 *  findfic_series.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_series
 *  Search for a string in series
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('highlight.php');
include_once('printcategory.php');

function findfic_series($src)
{
	global $cache, $tables, $tpl;

	$key = "findfic_series_" . md5(strtoupper($src));

	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->Get($key);
		if (!$res) {
			$res = DBGetArray("SELECT id,title FROM " . $tables['series'] . " WHERE UPPER(title) LIKE '%" . strtoupper($src) . "%' ORDER BY title");
			$cache->Set($key, $res);
		}
		if ($res) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching series:");
			$out .= $tpl->fetch("note.tpl");
		}
		foreach ($res as $row) {
			highlight($row['title'],$src);
			$out .= printcategory("series", "sid", $row['id'], $row['title'], null, null);
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}

?>
