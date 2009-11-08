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

function listfics_series($searchid = null, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache;

	$outkey = "output_listfics_series_" . $searchid . "_" . $highlight . "_" . md5($searchstring);

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$q = "SELECT id,title FROM " . $tables['series'];
		$key = "listfics_series";
		/*
		 * User only wants one series
		 */
		if (isset($searchid)) {
			$q .= " WHERE id = $searchid";
			$key .= "_" . $searchid;
		} else
			$q .= " ORDER BY title";
		$sl = $cache->Get($key);
		if (!$sl) {
			$sl = DBGetArray($q);
			$cache->Set($key, $sl);
		}

		/*
		 * Enumerate series list
		 */
		foreach ($sl as $row) {
			if ($highlight == CODEX_SERIES && $searchstring)
				highlight($row['title'],$searchstring);
			$out .= printcategory("series", "sid", $row['id'], $row['title'], null, null);
			$fl = series_fic($row['id']);

			/*
			 * Enumerate fics per series
			 */
			foreach ($fl as $row2)
				$out .= printfic($row2['id'],TRUE,$highlight,$searchstring);
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
