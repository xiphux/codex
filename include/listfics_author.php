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
include_once('author_fic.php');

function listfics_author($searchid = null, $highlight = 0, $searchstring = null)
{
	global $tables, $tpl, $cache;

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
	$al = $cache->get($key);
	if (!$al) {
		$al = DBGetArray($q);
		$cache->set($key, $al);
	}

	/*
	 * Enumerate author list
	 */
	foreach ($al as $row) {
		$tpl->clear_all_assign();
		$tpl->assign("catsort", "author");
		$tpl->assign("catidtype","aid");
		$tpl->assign("catid",$row['author_id']);
		if ($highlight == CODEX_AUTHOR && $searchstring)
			highlight($row['author_name'],$searchstring);
		$tpl->assign("catname",$row['author_name']);
		$tpl->assign("email",$row['author_email']);
		$tpl->assign("website",$row['author_website']);
		$tpl->display("category.tpl");
		$fl = author_fic($row['author_id']);

		/*
		 * Enumerate fics per author
		 */
		foreach ($fl as $row2)
			printfic($row2['fic_id'],FALSE,$highlight,$searchstring);
	}
}

?>
