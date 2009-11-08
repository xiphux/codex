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
		}
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
			$tmp = matchup_data($row['id']);
			if ($searchstring && (($highlight & CODEX_MATCHUP_1) || ($highlight & CODEX_MATCHUP_2)))
				highlight($tmp['matchup_name'],$searchstring,"searchtext",true);
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
