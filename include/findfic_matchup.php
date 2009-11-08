<?php
/*
 *  findfic_matchup.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_matchup
 *  Search for a string in matchups
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('highlight.php');
include_once('printcategory.php');
include_once('matchup_data.php');
include_once('series_title.php');

function findfic_matchup($src)
{
	global $cache, $tables, $tpl;

	$key = "findfic_matchup_" . md5(strtoupper($src));

	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->Get($key);
		if (!$res) {
			$res = DBGetArray("SELECT id FROM " . $tables['characters'] . " WHERE UPPER(name) LIKE '%" . strtoupper($src) . "%' ORDER BY name");
			$cache->Set($key, $res);
		}

		$ex = array();
		foreach ($res as $row) {
			$r = $cache->Get("match_" . $row['id']);
			if (!$r) {
				$r = DBGetArray("SELECT id FROM " . $tables['matchups'] . " WHERE character1 = " . $row['id'] . " OR character2 = " . $row['id']);
				$cache->Set("match_" . $row['id'], $r);
			}

			foreach ($r as $row2) {
				if (!in_array($row2['id'],$ex))
					$ex[] = $row2['id'];
			}
		}
		if (count($ex) > 0) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching matchups:");
			$out .= $tpl->fetch("note.tpl");
		}
		foreach ($ex as $mat) {
			$tmp = matchup_data($mat);
			highlight($tmp['matchup_name'], $src, "searchtext", true);
			var_dump($tmp['matchup_name']);
			$out .= printcategory("matchup", "mid", $mat, $tmp['matchup_name'], null, null);
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}

?>
