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
			$res = DBGetArray("SELECT id,name,email,website FROM " . $tables['authors'] . " ORDER BY name");
			$cache->Set($key, $res);
		}
		foreach ($res as $row) {
			if (fuzzysearch($row['name'],$src))
				$out .= printcategory("author", "aid", $row['id'], $row['name'], $row['email'], $row['website']);
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
