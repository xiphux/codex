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
include_once('printcategory.php');
include_once('matchupcmp.php');
include_once('matchup_data.php');
include_once('character_series.php');
include_once('series_title.php');
include_once('matchup_fic.php');

function listfics_matchup($searchid = null, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache;

	$outkey = "output_listfics_matchup_" . $searchid . "_" . $highlight . "_" . md5($searchstring);
	
	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$q = "SELECT id,character1,character2 FROM " . $tables['matchups'];
		$key = "listfics_matchup";
		/*
		 * User only wants one matchup
		 */
		if (isset($searchid)) {
			$q .= " WHERE id = $searchid";
			$key .= "_" . $searchid;
		} else
			$q .= " ORDER BY id";
		$ml = $cache->Get($key);
		if (!$ml) {
			$ml = DBGetArray($q);
			usort($ml,"matchupcmp");
			$cache->Set($key, $ml);
		}

		/*
		 * Enumerate matchup list
		 */
		foreach ($ml as $row) {
			if ($highlight == CODEX_MATCHUP_1 && $searchstring)
				highlight($tmp['match1'],$searchstring);
			if ($highlight == CODEX_MATCHUP_2 && $searchstring)
				highlight($tmp['match2'],$searchstring);
			$tmp = matchup_data($row['id']);
			$s1 = character_series($tmp['id1']);
			$s2 = character_series($tmp['id2']);
			if ($s1 != $s2) {
				$tmp['match1'] .= " (" . series_title($s1) . ")";
				$tmp['match2'] .= " (" . series_title($s2) . ")";
			}
			$tmp["matchup_name"] = $tmp['match1'] . " + " . $tmp['match2'];
			$out .= printcategory("matchup", "mid", $row['id'], $tmp['matchup_name'], null, null);
			$fl = matchup_fic($row['id']);

			/*
			 * Enumerate fics per matchup
			 */
			foreach ($fl as $row2)
				$out .= printfic($row2['id'],TRUE,$highlight,$searchstring);
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
