<?php
/*
 *  findfic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic
 *  Search for a string
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 include_once('findfic_title.php');
 include_once('findfic_author.php');
 include_once('findfic_series.php');
 include_once('findfic_genre.php');
 include_once('findfic_matchup.php');

function findfic($src = null)
{
	global $tables, $cache, $tpl, $codex_conf;
	if (isset($src)) {
		$outkey = "output_findfic_" . md5(strtoupper($src));
		$out = $cache->get($outkey);
		if (!$out) {
			$out = "";
			$src = addslashes($src);

			$out .= findfic_title($src);

			$out .= findfic_author($src);

			$out .= findfic_series($src);

			$out .= findfic_genre($src);

			$out .= findfic_matchup($src);

			$tpl->clear_all_assign();
			$tpl->assign("note", "Search for: <span class=\"searchtext\">" . $src . "</span>");
			$out = $tpl->fetch("note.tpl") . $out;

			$cache->set($outkey, $out);
		}
		return $out;
	} else
		return "Empty search";
}

?>
