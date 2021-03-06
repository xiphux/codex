<?php
/*
 *  findfic_genre_fuzzy.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_genre_fuzzy
 *  Fuzzy search for a string in genres
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

include_once('highlight.php');
include_once('printcategory.php');
include_once('fuzzysearch.php');

function findfic_genre_fuzzy($src)
{
	global $cache, $tables, $tpl, $codex_conf;

	$key = "findfic_genre_fuzzy_" . md5(strtoupper($src));
	if ($codex_conf['lemons'])
		$key .= "_lemon";
	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->Get($key);
		if (!$res) {
			$lim = "";
			if (!$codex_conf['lemons'])
				$lim = " WHERE UPPER(name) NOT LIKE 'LEMON%' ";
			$res = DBGetArray("SELECT id,name FROM " . $tables['genres'] . $lim . " ORDER BY name");
			$cache->Set($key, $res);
		}
		foreach ($res as $row) {
			if (fuzzysearch($row['name'],$src)) {
				if ($codex_conf['lemons']);
					highlight($row['name'],"Lemon","lemontext");
				$out .= printcategory("genre", "gid", $row['id'], $row['name'], null, null);
			}
		}
		if (strlen($out) > 0) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching genres:");
			$out = $tpl->fetch("note.tpl") . $out;
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}

?>
