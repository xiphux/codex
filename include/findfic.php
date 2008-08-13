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
 include_once('findfic_title_fuzzy.php');
 include_once('findfic_author.php');
 include_once('findfic_author_fuzzy.php');
 include_once('findfic_series.php');
 include_once('findfic_series_fuzzy.php');
 include_once('findfic_genre.php');
 include_once('findfic_genre_fuzzy.php');
 include_once('findfic_matchup.php');
 include_once('findfic_matchup_fuzzy.php');

function findfic($src = null)
{
	global $cache, $tpl, $codex_conf;
	if (isset($src)) {
		$outkey = "output_findfic_" . md5(strtoupper($src));
		$out = $cache->get($outkey);
		if (!$out) {
			$out = "";
			$src = addslashes($src);

			$tpl->clear_all_assign();
			$tpl->assign("note", "Search for: <span class=\"searchtext\">" . $src . "</span>");
			$outhead = $tpl->fetch("note.tpl");

			$out .= findfic_title($src);

			$out .= findfic_author($src);

			$out .= findfic_series($src);

			$out .= findfic_genre($src);

			$out .= findfic_matchup($src);

			if ((strlen($out) < 1) && ($codex_conf['fuzzysearchthreshold'] > 0)) {
				$tpl->clear_all_assign();
				$tpl->assign("note", "No exact matches found, attempting fuzzy search");
				$outhead .= $tpl->fetch("note.tpl");

				$out .= findfic_title_fuzzy($src);
				$out .= findfic_author_fuzzy($src);
				$out .= findfic_series_fuzzy($src);
				$out .= findfic_genre_fuzzy($src);
				$out .= findfic_matchup_fuzzy($src);
			}

			if (strlen($out) < 1) {
				$tpl->clear_all_assign();
				$tpl->assign("note", "No matches found");
				$out = $tpl->fetch("note.tpl");
			}

			$out = $outhead . $out;

			$cache->set($outkey, $out);
		}
		return $out;
	} else
		return "Empty search";
}

?>
