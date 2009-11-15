<?php
/*
 *  printfic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: printfic
 *  Print out a fic's information given a fic id
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 include_once('defs.php');
 include_once('highlight.php');
 include_once('fic_data.php');
 include_once('fic_author.php');
 include_once('fic_series.php');
 include_once('fic_genre.php');
 include_once('fic_matchup.php');
 include_once('chapter_count.php');
 include_once('get_viewcount.php');

function printfic($id, $author_info = TRUE, $highlight = 0, $search = null, $keywords = null)
{
	global $tpl,$codex_conf, $cache;

	$key = "output_printfic_" . $id . "_" . $highlight . "_" . md5($search);
	if ($author_info)
		$key .= "_ainfo";

	$out = $cache->Get($key);
	if (!$out) {

		/*
		 * Get the fic data
		 */
		$fdata = fic_data($id);

		/*
		 * Clear out old assigns
		 */
		$tpl->clear_all_assign();

		/*
		 * Whether to show full or compact links
		 */
		$tpl->assign("showemail", $codex_conf['showemail']);
		$tpl->assign("showwebsite", $codex_conf['showwebsite']);

		/*
		 * Highlight search string in title if specified
		 */
		if (($highlight & CODEX_TITLE) && $search) {
			if (isset($keywords))
				highlight_keywords($fdata["title"], $keywords);
			else
				highlight($fdata["title"],$search);
		}

		/*
		 * Export fic data
		 */
		$tpl->assign("fic",$fdata);

		/*
		 * Get author data
		 */
		$adata = fic_author($id);

		/*
		 * Omit the author's contact info (for author-based listings)
		 */
		if (!$author_info) {
			$tpl->assign("omitcontact", true);
		}

		/*
		 * Highlight a search string in author name if specified
		 */
		if (($highlight & CODEX_AUTHOR) && $search) {
			if (isset($keywords)) {
				foreach ($adata as $i => $aid) {
					highlight_keywords($adata[$i]["name"], $keywords);
					highlight_keywords($adata[$i]["email"], $keywords);
				}
			} else {
				foreach ($adata as $i => $aid) {
					highlight($adata[$i]["name"],$search);
					highlight($adata[$i]["email"],$search);
				}
			}
		}

		/*
		 * Export author(s)
		 */
		$tpl->assign("fic_author",$adata);

		/*
		 * Get count of chapters in fic
		 */
		$chapcount = chapter_count($id);

		/*
		 * Export chapter count
		 */
		$tpl->assign("chaptercount", $chapcount);

		if ($chapcount == 1) {
			$tpl->assign("showviews", true);
			$tpl->assign("views", get_viewcount($id, 1));
		}

		/*
		 * Get series data
		 */
		$sdata = fic_series($id);

		/*
		 * Highlight search string in series if specified
		 */
		if (($highlight & CODEX_SERIES) && $search) {
			if (isset($keywords)) {
				foreach ($sdata as $i => $sid)
					highlight_keywords($sdata[$i]["title"], $keywords);
			} else {
				foreach ($sdata as $i => $sid)
					highlight($sdata[$i]["title"],$search);
			}
		}

		/*
		 * Export series
		 */
		$tpl->assign("fic_series",$sdata);

		/*
		 * Get genre data
		 */
		$gdata = fic_genre($id);
		
		foreach ($gdata as $i => $gid) {
			/*
			 * Mark if genre is lemon
			 */
			highlight($gdata[$i]["name"],"Lemon","lemontext");

			/*
			 * Highlight search string in genre if specified
			 */
			if (($highlight & CODEX_GENRE) && $search) {
				if (isset($keywords))
					highlight_keywords($gdata[$i]["name"], $keywords);
				else
					highlight($gdata[$i]["name"],$search);
			}

			/*
			 * If lemons are disabled, don't finish displaying
			 */
			if (!$codex_conf['lemons'] && stristr($gdata[$i]["name"],"Lemon"))
				return;
		}

		/*
		 * Export genre data
		 */
		$tpl->assign("fic_genre",$gdata);

		/*
		 * Get matchup data
		 */
		$mdata = fic_matchup($id);
		
		foreach($mdata as $i => $mid) {
			if ($search && (($highlight & CODEX_MATCHUP_1) || ($highlight & CODEX_MATCHUP_2))) {
				if (isset($keywords))
					highlight_keywords($mdata[$i]["matchup_name"], $keywords,"searchtext",true);
				else
					highlight($mdata[$i]["matchup_name"],$search,"searchtext",true);
			}
		}

		/*
		 * Export matchup data
		 */
		$tpl->assign("fic_matchup",$mdata);

		$out = $tpl->fetch("entry.tpl");
		$cache->Set($key, $out);
	}

	return $out;
}

?>
