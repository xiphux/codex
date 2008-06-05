<?php
/*
 *  listfics.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: listfics
 *  List fics given a particular sort criteria
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 include_once('defs.php');
 include_once('highlight.php');
 include_once('genre_fic.php');
 include_once('printfic.php');
 include_once('series_fic.php');
 include_once('matchupcmp.php');
 include_once('matchup_data.php');
 include_once('character_series.php');
 include_once('series_title.php');
 include_once('matchup_fic.php');
 include_once('author_fic.php');

function listfics($sort = "title", $searchid = null, $highlight = 0, $searchstring = null)
{
	global $codex_conf,$db,$tpl,$tables;

	/*
	 * Sort by genre
	 */
	if ($sort == "genre") {
		$q = "SELECT * FROM " . $tables['genres'];

		/*
		 * User only wants one genre
		 */
		if (isset($searchid))
			$q .= " WHERE genre_id = $searchid";
		else
			$q .= " ORDER BY genre_name";
		$gl = $db->CacheGetArray($codex_conf['secs2cache'],$q);

		/*
		 * Enumerate genre list
		 */
		foreach ($gl as $row) {
			if (!stristr($row['genre_name'],"Lemon") || $codex_conf['lemons']) {
				$tpl->clear_all_assign();
				$tpl->assign("catsort",$sort);
				$tpl->assign("catidtype","gid");
				$tpl->assign("catid",$row['genre_id']);
				highlight($row['genre_name'],"Lemon","lemontext");
				if ($highlight == CODEX_GENRE && $searchstring)
					highlight($row['genre_name'],$searchstring);
				$tpl->assign("catname",$row['genre_name']);
				$tpl->display("category.tpl");
				$fl = genre_fic($row['genre_id']);
				/*
				 * Enumerate fics per genre
				 */
				foreach ($fl as $row2)
					printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
			}
		}
	
	/*
	 * Sort by series
	 */
	} else if ($sort == "series") {
		$q = "SELECT * FROM " . $tables['series'];

		/*
		 * User only wants one series
		 */
		if (isset($searchid))
			$q .= " WHERE series_id = $searchid";
		else
			$q .= " ORDER BY series_title";
		$sl = $db->CacheGetArray($codex_conf['secs2cache'],$q);

		/*
		 * Enumerate series list
		 */
		foreach ($sl as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort",$sort);
			$tpl->assign("catidtype","sid");
			$tpl->assign("catid",$row['series_id']);
			if ($highlight == CODEX_SERIES && $searchstring)
				highlight($row['series_title'],$searchstring);
			$tpl->assign("catname",$row['series_title']);
			$tpl->display("category.tpl");
			$fl = series_fic($row['series_id']);

			/*
			 * Enumerate fics per series
			 */
			foreach ($fl as $row2)
				printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
		}
	
	/*
	 * Sort by matchup
	 */
	} else if ($sort == "matchup") {
		$q = "SELECT * FROM " . $tables['matchups'];

		/*
		 * User only wants one matchup
		 */
		if (isset($searchid))
			$q .= " WHERE matchup_id = $searchid";
		else
			$q .= " ORDER BY matchup_id";
		$ml = $db->CacheGetArray($codex_conf['secs2cache'],$q);
		usort($ml,"matchupcmp");

		/*
		 * Enumerate matchup list
		 */
		foreach ($ml as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort",$sort);
			$tpl->assign("catidtype","mid");
			$tpl->assign("catid",$row['matchup_id']);
			$tmp = matchup_data($row['matchup_id']);
			if ($highlight == CODEX_MATCHUP_1 && $searchstring)
				highlight($tmp['match1'],$searchstring);
			if ($highlight == CODEX_MATCHUP_2 && $searchstring)
				highlight($tmp['match2'],$searchstring);
			$s1 = character_series($tmp['id1']);
			$s2 = character_series($tmp['id2']);
			if ($s1 != $s2) {
				$tmp['match1'] .= " (" . series_title($s1) . ")";
				$tmp['match2'] .= " (" . series_title($s2) . ")";
			}
			$tmp["matchup_name"] = $tmp['match1'] . " + " . $tmp['match2'];
			$tpl->assign("catname",$tmp['matchup_name']);
			$tpl->display("category.tpl");
			$fl = matchup_fic($row['matchup_id']);

			/*
			 * Enumerate fics per matchup
			 */
			foreach ($fl as $row2)
				printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
		}

	/*
	 * Sort by author
	 */
	} else if ($sort == "author") {
		$q = "SELECT * FROM " . $tables['authors'];

		/*
		 * User only wants one author
		 */
		if (isset($searchid))
			$q .= " WHERE author_id = $searchid";
		else
			$q .= " ORDER BY author_name";
		$al = $db->CacheGetArray($codex_conf['secs2cache'],$q);

		/*
		 * Enumerate author list
		 */
		foreach ($al as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort",$sort);
			$tpl->assign("catidtype","aid");
			$tpl->assign("catid",$row['author_id']);
			if ($highlight == CODEX_AUTHOR && $searchstring)
				highlight($row['author_name'],$searchstring);
			$tpl->assign("catname",$row['author_name']);
			$tpl->assign("email",$row['author_email']);
			$tpl->assign("website",$row['author_website']);
			$tpl->display("category.tpl");
			$fl = author_fic($row['author_id']);

			/*
			 * Enumerate fics per author
			 */
			foreach ($fl as $row2)
				printfic($row2['fic_id'],FALSE,$highlight,$searchstring);
		}
	
	/*
	 * Default case, sort alphabetically
	 */
	} else {
		$fl = $db->CacheGetCol($codex_conf['secs2cache'],"SELECT fic_id FROM " . $tables['fics'] . " ORDER BY fic_title");
		foreach ($fl as $row)
			printfic($row,TRUE,$highlight,$searchstring);
	}
}

?>
