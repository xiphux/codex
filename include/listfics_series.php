<?php
/*
 *  listfics_series.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_series
 *  List fics by series
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
include_once('defs.php');
include_once('highlight.php');
include_once('printfic.php');
include_once('printcategory.php');
include_once('series_fic.php');

function listfics_series($searchid = null, $page = 1, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache, $codex_conf;

	$outkey = "output_listfics_series_" . $searchid . "_" . $highlight . "_" . md5($searchstring) . "_" . $page;

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$key = "listfics_series";
		$q = "SELECT s1.id,s1.title,f1.id AS fid FROM " . $tables['series'] . " AS s1 RIGHT JOIN " . $tables['fic_series'] . " AS fs ON fs.series_id = s1.id RIGHT JOIN " . $tables['fics'] . " AS f1 ON fs.fic_id = f1.id";
		/*
		 * User only wants one series
		 */
		if (isset($searchid)) {
			$q .= " WHERE s1.id = $searchid ORDER BY f1.title";
			$key .= "_" . $searchid;
		} else
			$q .= " ORDER BY s1.title, f1.title";
		$sl = $cache->Get($key);
		if (!$sl) {
			$sl = DBSelectLimit($q, $codex_conf['itemsperpage'], (($page - 1) * $codex_conf['itemsperpage']));
			$cache->Set($key, $sl);
		}
		
		$count = $cache->Get($key . "_count");
		if (!$count) {
			$q = "SELECT COUNT(f1.id) FROM " . $tables['series'] . " AS s1 RIGHT JOIN " . $tables['fic_series'] . " AS fs ON fs.series_id = s1.id RIGHT JOIN " . $tables['fics'] . " AS f1 ON fs.fic_id = f1.id";
			if (isset($searchid))
				$q .= " WHERE s1.id = $searchid";
			$count = DBGetOne($q);
			$cache->Set($key . "_count", $count);
		}

		$previd = -1;

		while (!$sl->EOF) {
			if ($sl->fields['id'] != $previd) {
				$title = $sl->fields['title'];
				if (!isset($title)) {
					$out .= "<p><strong>Unknown</strong></p>";
				} else {
					if ($highlight == CODEX_SERIES && $searchstring)
						highlight($title,$searchstring);
					$out .= printcategory("series", "sid", $sl->fields['id'], $title, null, null);
				}
				$previd = $sl->fields['id'];
			}
			$out .= printfic($sl->fields['fid'],TRUE,$highlight,$searchstring);
			$sl->MoveNext();
		}

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
			$tpl->assign("pagerdest", "series");
			if (isset($searchid))
				$tpl->assign("pagerseriesid", $searchid);
			$pagerout = $tpl->fetch("pager.tpl");
			$out = $pagerout . $out . $pagerout;
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
