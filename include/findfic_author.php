<?php
/*
 *  findfic_author.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_author
 *  Search for a string in authors
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('highlight.php');
include_once('printcategory.php');

function findfic_author($src)
{
	global $cache, $tables, $tpl;

	$key = md5(strtoupper($src));

	$out = $cache->get("output_findfic_author_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->get("findfic_author_" . $key);
		if (!$res) {
			$res = DBGetArray("SELECT author_id,author_name,author_email,author_website FROM " . $tables['authors'] . " WHERE UPPER(author_name) LIKE '%" . strtoupper($src) . "%' ORDER BY author_name");
			$cache->set("findfic_author_" . $key, $res);
		}
		if ($res) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching authors:");
			$out .= $tpl->fetch("note.tpl");
		}
		foreach ($res as $row) {
			highlight($row['author_name'],$src);
			$out .= printcategory("author", "aid", $row['author_id'], $row['author_name'], $row['author_email'], $row['author_website']);
		}
		$cache->set("output_findfic_author_" . $key, $out);
	}
	return $out;
}

?>
