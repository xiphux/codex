<?php
/*
 *  findfic_title_fuzzy.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_title_fuzzy
 *  Fuzzy search for a string in titles
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

include_once('defs.php');
include_once('printfic.php');
include_once('fuzzysearch.php');

function findfic_title_fuzzy($src)
{
	global $cache, $tables, $tpl;

	$key = "findfic_title_fuzzy_" . md5(strtoupper($src));

	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->Get($key);
		if (!$res) {
			$res = DBGetArray("SELECT fic_id,fic_title FROM " . $tables['fics'] . " ORDER BY fic_title");
			$cache->Set($key, $res);
		}
		foreach ($res as $row) {
			if (fuzzysearch($row['fic_title'],$src))
				$out .= printfic($row['fic_id'],TRUE,CODEX_TITLE,$src);
		}
		if (strlen($out) > 0) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching titles:");
			$out = $tpl->fetch("note.tpl") . $out;
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}

?>
