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

function listfics_genre($searchid = null, $highlight = 0, $searchstring = null)
{
	global $codex_conf, $tables, $tpl;

	$q = "SELECT * FROM " . $tables['genres'];

	/*
	 * User only wants one genre
	 */
	if (isset($searchid))
		$q .= " WHERE genre_id = $searchid";
	else
		$q .= " ORDER BY genre_name";
	$gl = DBGetArray($q);

	/*
	 * Enumerate genre list
	 */
	foreach ($gl as $row) {
		if (!stristr($row['genre_name'],"Lemon") || $codex_conf['lemons']) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort", "genre");
			$tpl->assign("catidtype","gid");
			$tpl->assign("catid",$row['genre_id']);
			highlight($row['genre_name'],"Lemon","lemontext");
			if ($highlight == CODEX_GENRE && $searchstring)
				highlight($row['genre_name'],$searchstring);
			$tpl->assign("catname",$row['genre_name']);
			$tpl->display("category.tpl");
			$fl = genre_fic($row['genre_id']);
			/*
			 * Enumerate fics per genre
			 */
			foreach ($fl as $row2)
				printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
		}
	}
}

?>
