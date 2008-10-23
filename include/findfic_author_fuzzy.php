<?php
/*
 *  findfic_author_fuzzy.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_author_fuzzy
 *  Fuzzy search for a string in authors
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

include_once('printcategory.php');
include_once('fuzzysearch.php');

function findfic_author_fuzzy($src)
{
	global $cache, $tables, $tpl;

	$key = "findfic_author_fuzzy_" . md5(strtoupper($src));

	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->Get($key);
		if (!$res) {
			$res = DBGetArray("SELECT author_id,author_name,author_email,author_website FROM " . $tables['authors'] . " ORDER BY author_name");
			$cache->Set($key, $res);
		}
		foreach ($res as $row) {
			if (fuzzysearch($row['author_name'],$src))
				$out .= printcategory("author", "aid", $row['author_id'], $row['author_name'], $row['author_email'], $row['author_website']);
		}
		if (strlen($out) > 0) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching authors:");
			$out = $tpl->fetch("note.tpl") . $out;
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}

?>
