<?php
/*
 *  listfics_matchup.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_matchup
 *  List fics by matchup
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
include_once('defs.php');
include_once('highlight.php');
include_once('printfic.php');
include_once('matchupcmp.php');
include_once('matchup_data.php');
include_once('character_series.php');
include_once('series_title.php');
include_once('matchup_fic.php');

function listfics_matchup($searchid = null, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache;

	$outkey = "output_listfics_matchup_" . $searchid . "_" . $highlight . "_" . md5($searchstring);
	
	$out = $cache->get($outkey);
	if (!$out) {
		$out = "";

		$q = "SELECT * FROM " . $tables['matchups'];
		$key = "listfics_matchup";
		/*
		 * User only wants one matchup
		 */
		if (isset($searchid)) {
			$q .= " WHERE matchup_id = $searchid";
			$key .= "_" . $searchid;
		} else
			$q .= " ORDER BY matchup_id";
		$ml = $cache->get($key);
		if (!$ml) {
			$ml = DBGetArray($q);
			usort($ml,"matchupcmp");
			$cache->set($key, $ml);
		}

		/*
		 * Enumerate matchup list
		 */
		foreach ($ml as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort", "matchup");
			$tpl->assign("catidtype","mid");
			$tpl->assign("catid",$row['matchup_id']);
			$tmp = matchup_data($row['matchup_id']);
			if ($highlight == CODEX_MATCHUP_1 && $searchstring)
				highlight($tmp['match1'],$searchstring);
			if ($highlight == CODEX_MATCHUP_2 && $searchstring)
				highlight($tmp['match2'],$searchstring);
			$s1 = character_series($tmp['id1']);
			$s2 = character_series($tmp['id2']);
			if ($s1 != $s2) {
				$tmp['match1'] .= " (" . series_title($s1) . ")";
				$tmp['match2'] .= " (" . series_title($s2) . ")";
			}
			$tmp["matchup_name"] = $tmp['match1'] . " + " . $tmp['match2'];
			$tpl->assign("catname",$tmp['matchup_name']);
			$out .= $tpl->fetch("category.tpl");
			$fl = matchup_fic($row['matchup_id']);

			/*
			 * Enumerate fics per matchup
			 */
			foreach ($fl as $row2)
				$out .= printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
		}

		$cache->set($outkey, $out);
	}
	return $out;
}

?>
