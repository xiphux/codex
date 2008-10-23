<?php
/*
 *  findfic_series_fuzzy.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_series_fuzzy
 *  Fuzzy search for a string in series
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

include_once('printcategory.php');
include_once('fuzzysearch.php');

function findfic_series_fuzzy($src)
{
	global $cache, $tables, $tpl;

	$key = "findfic_series_fuzzy_" . md5(strtoupper($src));

	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->Get($key);
		if (!$res) {
			$res = DBGetArray("SELECT series_id,series_title FROM " . $tables['series'] . " ORDER BY series_title");
			$cache->Set($key, $res);
		}
		foreach ($res as $row) {
			if (fuzzysearch($row['series_title'],$src))
				$out .= printcategory("series", "sid", $row['series_id'], $row['series_title'], null, null);
		}
		if (strlen($out) > 0) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching series:");
			$out = $tpl->fetch("note.tpl") . $out;
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}

?>
