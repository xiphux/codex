<?php
/*
 *  listfics_genre.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_genre
 *  List fics by genre
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('defs.php');
include_once('highlight.php');
include_once('genre_fic.php');
include_once('printfic.php');
include_once('printcategory.php');

function listfics_genre($searchid = null, $highlight = 0, $searchstring = null)
{
	global $codex_conf, $tables, $tpl, $cache;

	$outkey = "output_listfics_genre_" . $searchid . "_" . $highlight . "_" . md5($searchstring);
	if ($codex_conf['lemons'])
		$outkey .= "_lemons";

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";

		$q = "SELECT id,name FROM " . $tables['genres'];
		$key = "listfics_genre";
		/*
		 * User only wants one genre
		 */
		if (isset($searchid)) {
			$q .= " WHERE id = $searchid";
			$key .= "_" . $searchid;
		} else
			$q .= " ORDER BY name";
		$gl = $cache->Get($key);
		if (!$gl) {
			$gl = DBGetArray($q);
			$cache->Set($key, $gl);
		}

		/*
		 * Enumerate genre list
		 */
		foreach ($gl as $row) {
			if (!stristr($row['name'],"Lemon") || $codex_conf['lemons']) {
				if ($highlight == CODEX_GENRE && $searchstring)
					highlight($row['name'],$searchstring);
				highlight($row['name'],"Lemon","lemontext");
				$out .= printcategory("genre", "gid", $row['id'], $row['name'], null, null);
				$fl = genre_fic($row['id']);
				/*
				 * Enumerate fics per genre
				 */
				foreach ($fl as $row2)
					$out .= printfic($row2['id'],TRUE,$highlight,$searchstring);
			}
		}
		
		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
