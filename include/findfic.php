<?php
/*
 *  findfic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: findfic
 *  Search for a string
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 include_once('defs.php');
 include_once('printfic.php');
 include_once('printcategory.php');
 include_once('listfics_author.php');
 include_once('listfics_series.php');
 include_once('listfics_genre.php');
 include_once('listfics_matchup.php');
 include_once('matchupcmp.php');
 include_once('matchup_data.php');
 include_once('character_series.php');
 include_once('series_title.php');

function findfic($src = null)
{
	global $tables, $cache, $tpl, $codex_conf;
	if (isset($src)) {
		$outkey = "output_findfic_" . md5($src);
		$out = $cache->get($outkey);
		if (!$out) {
			$out = "";
			$src = addslashes($src);
			$found = FALSE;
			$key = md5(strtoupper($src));

			/*
			 * Substring search fic title
			 */
			$subout = $cache->get("output_findfic_title_" . $key);
			if (!$subout) {
				$subout = "";
				$res = $cache->get("findfic_title_" . $key);
				if (!$res) {
					$res = DBGetArray("SELECT fic_id FROM " . $tables['fics'] . " WHERE UPPER(fic_title) LIKE '%" . strtoupper($src) . "%' ORDER BY fic_title");
					$cache->set("findfic_title_" . $key, $res);
				}
				if ($res) {
					$tpl->clear_all_assign();
					$tpl->assign("note", "Matching titles:");
					$subout .= $tpl->fetch("note.tpl");
					$found = TRUE;
				}
				foreach ($res as $row) {
					$subout .= printfic($row['fic_id'],TRUE,CODEX_TITLE,$src);
				}
				$cache->set("output_findfic_title_" . $key, $subout);
			}
			$out .= $subout;

			/*
			 * Substring search fic author
			 */
			$subout = $cache->get("output_findfic_author_" . $key);
			if (!$subout) {
				$subout = "";
				$res = $cache->get("findfic_author_" . $key);
				if (!$res) {
					$res = DBGetArray("SELECT author_id,author_name,author_email,author_website FROM " . $tables['authors'] . " WHERE UPPER(author_name) LIKE '%" . strtoupper($src) . "%' ORDER BY author_name");
					$cache->set("findfic_author_" . $key, $res);
				}
				if ($res) {
					$tpl->clear_all_assign();
					$tpl->assign("note", "Matching authors:");
					$subout .= $tpl->fetch("note.tpl");
					$found = TRUE;
				}
				foreach ($res as $row) {
					highlight($row['author_name'],$src);
					$subout .= printcategory("author", "aid", $row['author_id'], $row['author_name'], $row['author_email'], $row['author_website']);
				}
				$cache->set("output_findfic_author_" . $key, $subout);
			}
			$out .= $subout;

			/*
			 * Substring search fic series
			 */
			$subout = $cache->get("output_findfic_series_" . $key);
			if (!$subout) {
				$subout = "";
				$res = $cache->get("findfic_series_" . $key);
				if (!$res) {
					$res = DBGetArray("SELECT series_id,series_title FROM " . $tables['series'] . " WHERE UPPER(series_title) LIKE '%" . strtoupper($src) . "%' ORDER BY series_title");
					$cache->set("findfic_series_" . $key, $res);
				}
				if ($res) {
					$tpl->clear_all_assign();
					$tpl->assign("note", "Matching series:");
					$subout .= $tpl->fetch("note.tpl");
					$found = TRUE;
				}
				foreach ($res as $row) {
					highlight($row['series_title'],$src);
					$subout .= printcategory("series", "sid", $row['series_id'], $row['series_title'], null, null);
				}
				$cache->set("output_findfic_series_" . $key, $subout);
			}
			$out .= $subout;

			/*
			 * Substring search fic genre
			 */
			$outputgenrekey = "output_findfic_genre_" . $key;
			if ($codex_conf['lemons'])
				$outputgenrekey .= "_lemon";
			$subout = $cache->get($outputgenrekey);
			if (!$subout) {
				$subout = "";
				$genrekey = "findfic_genre_" . $key;
				if ($codex_conf['lemons'])
					$genrekey .= "_lemon";
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
					$subout .= $tpl->fetch("note.tpl");
					$found = TRUE;
				}
				foreach ($res as $row) {
					highlight($row['genre_name'],$src);
					if ($codex_conf['lemons']);
						highlight($row['genre_name'],"Lemon","lemontext");
					$subout .= printcategory("genre", "gid", $row['genre_id'], $row['genre_name'], null, null);
				}
				$cache->set($outputgenrekey, $subout);
			}
			$out .= $subout;

			/*
			 * Substring search fic characters/matchups
			 */
			$subout = $cache->get("output_findfic_character_" . $key);
			if (!$subout) {
				$subout = "";
				$res = $cache->get("findfic_character_" . $key);
				if (!$res) {
					$res = DBGetArray("SELECT character_id FROM " . $tables['characters'] . " WHERE UPPER(character_name) LIKE '%" . strtoupper($src) . "%' ORDER BY character_name");
					$cache->set("findfic_character_" . $key, $res);
				}
				/*
				 * Already listed matchups array
				 */
				$ex = array();
				foreach ($res as $row) {
					/*
					 * Get matchups for character 1
					 */
					$r = $cache->get("match1_" . $row['character_id']);
					if (!$r) {
						$r = DBGetArray("SELECT matchup_id FROM " . $tables['matchups'] . " WHERE match_1 = " . $row['character_id']);
						$cache->set("match1_" . $row['character_id'], $r);
					}

					/*
					 * Sort alphabetically
					 */
					usort($r,"matchupcmp");
					foreach ($r as $row2) {
						/*
						 * If not shown, list
						 */
						if (!in_array($row2['matchup_id'],$ex)) {
							$found = TRUE;
							$ex[] = $row2['matchup_id'];
						}
					}

					/*
					 * Get matchups for character 2
					 */
					$r = $cache->get("match2_" . $row['character_id']);
					if (!$r) {
						$r = DBGetArray("SELECT matchup_id FROM " . $tables['matchups'] . " WHERE match_2 = {$row['character_id']}");
						$cache->set("match2_" . $row['character_id'], $r);
					}

					foreach ($r as $row2) {
						/*
						 * If not shown, list
						 */
						if (!in_array($row2['matchup_id'],$ex)) {
							$found = TRUE;
							$ex[] = $row2['matchup_id'];
						}
					}
				}
				if (count($ex) > 0) {
					$tpl->clear_all_assign();
					$tpl->assign("note", "Matching matchups:");
					$subout .= $tpl->fetch("note.tpl");
					$found = TRUE;
				}
				foreach ($ex as $mat) {
					$tmp = matchup_data($mat);
					highlight($tmp['match1'], $src);
					highlight($tmp['match2'], $src);
					$s1 = character_series($tmp['id1']);
					$s2 = character_series($tmp['id2']);
					if ($s1 != $s2) {
						$tmp['match1'] .= " (" . series_title($s1) . ")";
						$tmp['match2'] .= " (" . series_title($s2) . ")";
					}
					$tmp["matchup_name"] = $tmp['match1'] . " + " . $tmp['match2'];
					$subout .= printcategory("matchup", "mid", $mat, $tmp['matchup_name'], null, null);
				}
				$cache->set("output_findfic_character_" . $key, $subout);
			}
			$out .= $subout;

			$cache->set($outkey, $out);
		}
		return $out;
	}
}

?>
