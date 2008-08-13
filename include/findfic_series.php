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

	$out = $cache->get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->get($key);
		if (!$res) {
			$res = DBGetArray("SELECT series_id,series_title FROM " . $tables['series'] . " WHERE UPPER(series_title) LIKE '%" . strtoupper($src) . "%' ORDER BY series_title");
			$cache->set($key, $res);
		}
		if ($res) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching series:");
			$out .= $tpl->fetch("note.tpl");
		}
		foreach ($res as $row) {
			highlight($row['series_title'],$src);
			$out .= printcategory("series", "sid", $row['series_id'], $row['series_title'], null, null);
		}
		$cache->set("output_" . $key, $out);
	}
	return $out;
}

?>
