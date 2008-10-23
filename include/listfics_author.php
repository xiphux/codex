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
		$q = "SELECT * FROM " . $tables['authors'];
		$key = "listfics_author";
		/*
		 * User only wants one author
		 */
		if (isset($searchid)) {
			$q .= " WHERE author_id = $searchid";
			$key .= "_" . $searchid;
		} else
			$q .= " ORDER BY author_name";
		$al = $cache->Get($key);
		if (!$al) {
			$al = DBGetArray($q);
			$cache->Set($key, $al);
		}

		/*
		 * Enumerate author list
		 */
		foreach ($al as $row) {
			if ($highlight == CODEX_AUTHOR && $searchstring)
				highlight($row['author_name'],$searchstring);
			$out .= printcategory("author", "aid", $row['author_id'], $row['author_name'], $row['author_email'], $row['author_website']);
			$fl = author_fic($row['author_id']);

			/*
			 * Enumerate fics per author
			 */
			foreach ($fl as $row2)
				$out .= printfic($row2['fic_id'],FALSE,$highlight,$searchstring);
		}

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
