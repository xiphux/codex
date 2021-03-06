<?php
/*
 *  findfic_matchup_fuzzy.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_matchup_fuzzy
 *  Fuzzy search for a string in matchups
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

include_once('printcategory.php');
include_once('matchup_data.php');
include_once('fuzzysearch.php');

function findfic_matchup_fuzzy($src)
{
	global $cache, $tables, $tpl;

	$key = "findfic_matchup_fuzzy_" . md5(strtoupper($src));

	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->Get($key);
		if (!$res) {
			$res = DBGetCol("SELECT id FROM " . $tables['matchups']);
			$cache->Set($key, $res);
		}
		foreach ($res as $mat) {
			$tmp = matchup_data($mat);
			if (fuzzysearch($tmp['match1'],$src) || fuzzysearch($tmp['match2'],$src)) {
				$out .= printcategory("matchup", "mid", $mat, $tmp['matchup_name'], null, null);
			}
		}
		if (strlen($out) > 0) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching matchups:");
			$out = $tpl->fetch("note.tpl") . $out;
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}

?>
