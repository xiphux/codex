<?php
/*
 *  findfic_title.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_title
 *  Search for a string in titles
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('defs.php');
include_once('printfic.php');

function findfic_title($src)
{
	global $cache, $tables, $tpl;

	$key = md5(strtoupper($src));

	$out = $cache->get("output_findfic_title_" . $key);
	if (!$out) {
		$out = "";
		$res = $cache->get("findfic_title_" . $key);
		if (!$res) {
			$res = DBGetArray("SELECT fic_id FROM " . $tables['fics'] . " WHERE UPPER(fic_title) LIKE '%" . strtoupper($src) . "%' ORDER BY fic_title");
			$cache->set("findfic_title_" . $key, $res);
		}
		if ($res) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching titles:");
			$out .= $tpl->fetch("note.tpl");
		}
		foreach ($res as $row) {
			$out .= printfic($row['fic_id'],TRUE,CODEX_TITLE,$src);
		}
		$cache->set("output_findfic_title_" . $key, $out);
	}
	return $out;
}

?>