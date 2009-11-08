<?php
/*
 *  listfics_author.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics_author
 *  List fics by author
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
include_once('defs.php');
include_once('highlight.php');
include_once('printfic.php');
include_once('printcategory.php');
include_once('author_fic.php');

function listfics_author($searchid = null, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache;

	$outkey = "output_listfics_author_" . $searchid . "_" . $highlight . "_" . md5($searchstring);

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = "";
		$q = "SELECT id,name,email,website FROM " . $tables['authors'];
		$key = "listfics_author";
		/*
		 * User only wants one author
		 */
		if (isset($searchid)) {
			$q .= " WHERE id = $searchid AND ((" . $tables['authors'] . ".name IS NOT NULL) OR (" . $tables['authors'] . ".email IS NOT NULL))";
			$key .= "_" . $searchid;
		} else
			$q .= " WHERE (" . $tables['authors'] . ".name IS NOT NULL) OR (" . $tables['authors'] . ".email IS NOT NULL) ORDER BY name";
		$al = $cache->Get($key);
		if (!$al) {
			$al = DBGetArray($q);
			$cache->Set($key, $al);
		}

		/*
		 * Enumerate author list
		 */
		foreach ($al as $row) {
			if ($highlight == CODEX_AUTHOR && $searchstring) {
				highlight($row['name'],$searchstring);
				highlight($row['email'],$searchstring);
			}
			$out .= printcategory("author", "aid", $row['id'], (isset($row['name']) ? $row['name'] : $row['email']), $row['email'], $row['website']);
			$fl = author_fic($row['id']);

			/*
			 * Enumerate fics per author
			 */
			foreach ($fl as $row2)
				$out .= printfic($row2['id'],FALSE,$highlight,$searchstring);
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
