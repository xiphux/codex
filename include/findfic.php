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
 include_once('listfics_author.php');
 include_once('listfics_series.php');
 include_once('listfics_genre.php');
 include_once('listfics_matchup.php');
 include_once('matchupcmp.php');

function findfic($src = null)
{
	global $tables;
	if (isset($src)) {
	 	$found = FALSE;

		/*
		 * Substring search fic title
		 */
		$res = DBGetArray("SELECT fic_id FROM " . $tables['fics'] . " WHERE UPPER(fic_title) LIKE '%" . strtoupper($src) . "%' ORDER BY fic_title");
		foreach ($res as $row) {
			$found = TRUE;
			printfic($row['fic_id'],TRUE,CODEX_TITLE,$src);
		}

		/*
		 * Substring search fic author
		 */
		$res = DBGetArray("SELECT author_id FROM " . $tables['authors'] . " WHERE UPPER(author_name) LIKE '%" . strtoupper($src) . "%' ORDER BY author_name");
		foreach ($res as $row) {
			$found = TRUE;
			listfics_author($row['author_id'],CODEX_AUTHOR,$src);
		}

		/*
		 * Substring search fic series
		 */
		$res = DBGetArray("SELECT series_id FROM " . $tables['series'] . " WHERE UPPER(series_title) LIKE '%" . strtoupper($src) . "%' ORDER BY series_title");
		foreach ($res as $row) {
			$found = TRUE;
			listfics_series($row['series_id'],CODEX_SERIES,$src);
		}

		/*
		 * Substring search fic genre
		 */
		$res = DBGetArray("SELECT genre_id FROM " . $tables['genres'] . " WHERE UPPER(genre_name) LIKE '%" . strtoupper($src) . "%' ORDER BY genre_name");
		foreach ($res as $row) {
			$found = TRUE;
			listfics_genre($row['genre_id'],CODEX_GENRE,$src);
		}

		/*
		 * Substring search fic characters/matchups
		 */
		$res = DBGetArray("SELECT character_id FROM " . $tables['characters'] . " WHERE UPPER(character_name) LIKE '%" . strtoupper($src) . "%' ORDER BY character_name");
		/*
		 * Already listed matchups array
		 */
		$ex = array();
		foreach ($res as $row) {
			/*
			 * Get matchups for character 1
			 */
			$r = DBGetArray("SELECT matchup_id FROM " . $tables['matchups'] . " WHERE match_1 = " . $row['character_id']);

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
					listfics_matchup($row2['matchup_id'],CODEX_MATCHUP_1,$src);
				}
			}

			/*
			 * Get matchups for character 2
			 */
			$r = DBGetArray("SELECT matchup_id FROM " . $tables['matchups'] . " WHERE match_2 = {$row['character_id']}");

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
					listfics_matchup($row2['matchup_id'],CODEX_MATCHUP_2,$src);
				}
			}
		}
	}
}

?>
