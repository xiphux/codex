<?php
/*
 * findfic_keywords.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: findfic_keywords
 * Search for keywords
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

include_once('highlight_keywords.php');
include_once('printfic.php');
include_once('search_to_keywords.php');
include_once('keywords_to_query.php');

function findfic_keywords($src)
{
	global $cache, $tables, $tpl;

	$key = "findfic_keywords_" . md5(strtoupper($src));

	$out = $cache->Get("output_" . $key);
	if (!$out) {
		$out = "";
		$keywords = search_to_keywords($src);
		$res = $cache->Get($key);
		if (!$res) {
			$query = "SELECT id FROM " . $tables['fics'];
			$criteria = keywords_to_query($keywords);
			if (strlen($criteria) > 0)
				$query .= ' WHERE ' . $criteria;
			$query .= ' ORDER BY title';
			$res = DBGetArray($query);
			$cache->Set($key, $res);
		}
		if ($res) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Keyword matches:");
			$out .= $tpl->fetch("note.tpl");
		}
		foreach ($res as $row) {
			$out .= printfic($row['id'],TRUE,CODEX_ALL, $src, $keywords);
		}
		$cache->Set("output_" . $key, $out);
	}
	return $out;
}
