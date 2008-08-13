<?php
/*
 *  findfic_genre.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic_genre
 *  Search for a string in genres
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('highlight.php');
include_once('printcategory.php');

function findfic_genre($src)
{
	global $cache, $tables, $tpl, $codex_conf;

	$key = md5(strtoupper($src));

	$genrekey = "findfic_genre_" . $key;
	if ($codex_conf['lemons'])
		$genrekey .= "_lemon";
	$out = $cache->get("output_" . $genrekey);
	if (!$out) {
		$out = "";
		$res = $cache->get($genrekey);
		if (!$res) {
			$lim = "";
			if (!$codex_conf['lemons'])
				$lim = " AND UPPER(genre_name) NOT LIKE 'LEMON%' ";
			$res = DBGetArray("SELECT genre_id,genre_name FROM " . $tables['genres'] . " WHERE UPPER(genre_name) LIKE '%" . strtoupper($src) . "%' " . $lim . " ORDER BY genre_name");
			$cache->set($genrekey, $res);
		}
		if ($res) {
			$tpl->clear_all_assign();
			$tpl->assign("note", "Matching genres:");
			$out .= $tpl->fetch("note.tpl");
		}
		foreach ($res as $row) {
			if ($codex_conf['lemons']);
				highlight($row['genre_name'],"Lemon","lemontext");
			highlight($row['genre_name'],$src);
			$out .= printcategory("genre", "gid", $row['genre_id'], $row['genre_name'], null, null);
		}
		$cache->set("output_" . $genrekey, $out);
	}
	return $out;
}

?>
