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
include_once('series_fic.php');

function listfics_series($searchid = null, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache;

	$outkey = "output_listfics_series_" . $searchid . "_" . $highlight . "_" . md5($searchstring);

	$out = $cache->get($outkey);
	if (!$out) {
		$out = "";

		$q = "SELECT * FROM " . $tables['series'];
		$key = "listfics_series";
		/*
		 * User only wants one series
		 */
		if (isset($searchid)) {
			$q .= " WHERE series_id = $searchid";
			$key .= "_" . $searchid;
		} else
			$q .= " ORDER BY series_title";
		$sl = $cache->get($key);
		if (!$sl) {
			$sl = DBGetArray($q);
			$cache->set($key, $sl);
		}

		/*
		 * Enumerate series list
		 */
		foreach ($sl as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort", "series");
			$tpl->assign("catidtype","sid");
			$tpl->assign("catid",$row['series_id']);
			if ($highlight == CODEX_SERIES && $searchstring)
				highlight($row['series_title'],$searchstring);
			$tpl->assign("catname",$row['series_title']);
			$out .= $tpl->fetch("category.tpl");
			$fl = series_fic($row['series_id']);

			/*
			 * Enumerate fics per series
			 */
			foreach ($fl as $row2)
				$out .= printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
		}

		$cache->set($outkey, $out);
	}
	return $out;
}

?>
