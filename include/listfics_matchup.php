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
include_once('printcategoryunknown.php');

function listfics_matchup($searchid = null, $page = 1, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache, $codex_conf;

	$outkey = "output_listfics_matchup_" . $searchid . "_" . $highlight . "_" . md5($searchstring);
	
	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$q = "SELECT m1.id, IF(s1.id=s2.id,CONCAT(char1.name,' + ',char2.name,' (',s1.title,')'),CONCAT(char1.name,' (',s1.title,') + ',char2.name,' (',s2.title,')')) AS matchup_name, f1.id AS fid FROM " . $tables['matchups'] . " AS m1 LEFT JOIN " . $tables['characters'] . " AS char1 ON char1.id = m1.character1 LEFT JOIN " . $tables['characters'] . " AS char2 ON char2.id = m1.character2 LEFT JOIN " . $tables['characters_series'] . " AS cs1 ON char1.id = cs1.character_id LEFT JOIN " . $tables['series'] . " AS s1 ON cs1.series_id = s1.id LEFT JOIN " . $tables['characters_series'] . " AS cs2 ON char2.id = cs2.character_id LEFT JOIN " . $tables['series'] . " AS s2 ON cs2.series_id = s2.id RIGHT JOIN " . $tables['fic_matchup'] . " AS fm ON fm.matchup_id = m1.id LEFT JOIN " . $tables['fics'] . " AS f1 ON fm.fic_id = f1.id";
		$key = "listfics_matchup";
		/*
		 * User only wants one matchup
		 */
		if (isset($searchid)) {
			$q .= " WHERE m1.id = $searchid ORDER BY f1.title";
			$key .= "_" . $searchid;
		} else {
			$q .= " ORDER BY matchup_name, f1.title";
		}

		$ml = $cache->Get($key);
		if (!$ml) {
			$ml = DBSelectLimit($q, $codex_conf['itemsperpage'], (($page - 1) * $codex_conf['itemsperpage']));;
			$cache->Set($key, $ml);
		}

		$count = $cache->Get($key . "_count");
		if (!$count) {
			$q = "SELECT COUNT(f1.id) FROM " . $tables['matchups'] . " AS m1 RIGHT JOIN " . $tables['fic_matchup'] . " AS fm ON fm.matchup_id = m1.id LEFT JOIN " . $tables['fics'] . " AS f1 ON fm.fic_id = f1.id";
			if (isset($searchid))
				$q .= " WHERE m1.id = $searchid";
			$count = DBGetOne($q);
			$cache->Set($key . "_count", $count);
		}

		$previd = -1;

		while (!$ml->EOF) {
			if ($ml->fields['id'] != $previd) {
				$matchup = $ml->fields['matchup_name'];
				if (!isset($matchup)) {
					$out .= printcategoryunknown();
				} else {
					if ($searchstring && (($highlight & CODEX_MATCHUP_1) || ($highlight & CODEX_MATCHUP_2)))
						highlight($matchup,$searchstring,"searchtext",true);
					$out .= printcategory("matchup", "mid", $ml->fields['id'], $matchup, null, null);
				}
				$previd = $ml->fields['id'];
			}
			$out .= printfic($ml->fields['fid'],TRUE,$highlight,$searchstring);
			$ml->MoveNext();
		}
		$ml->Close();

		$showpager = false;
		if ($page > 1) {
			$showpager = true;
			$tpl->assign("pagerprev", ($page-1));
		}
		if ($count > ($page * $codex_conf['itemsperpage'])) {
			$showpager = true;
			$tpl->assign("pagernext", ($page+1));
		}
		if ($showpager) {
			$tpl->assign("pagerdest", "matchup");
			if (isset($searchid))
				$tpl->assign("pagermatchupid", $searchid);
			$pagerout = $tpl->fetch("pager.tpl");
			$out = $pagerout . $out . $pagerout;
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
