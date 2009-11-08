<?php
/*
 *  fic_matchup.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_matchup
 *  Given a fic_id, get the matchup characters for it
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_matchup($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("fic_matchup_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT m1.id, char1.name AS match1, char1.id AS id1, char2.name AS match2, char2.id AS id2, s1.title as title1, s2.title as title2, IF(s1.id=s2.id,CONCAT(char1.name,' + ',char2.name),CONCAT(char1.name,' (',s1.title,') + ',char2.name,' (',s2.title,')')) AS matchup_name FROM " . $tables['fic_matchup'] . " AS fm1 LEFT JOIN " . $tables['matchups'] . " AS m1 ON fm1.matchup_id = m1.id LEFT JOIN " . $tables['characters'] . " AS char1 ON char1.id = m1.character1 LEFT JOIN " . $tables['characters'] . " AS char2 ON char2.id = m1.character2 LEFT JOIN " . $tables['characters_series'] . " AS cs1 ON char1.id = cs1.character_id LEFT JOIN " . $tables['series'] . " AS s1 ON cs1.series_id = s1.id LEFT JOIN " . $tables['characters_series'] . " AS cs2 ON char2.id = cs2.character_id LEFT JOIN " . $tables['series'] . " AS s2 ON cs2.series_id = s2.id WHERE fm1.fic_id = " . $id);
		$cache->Set("fic_matchup_" . $id, $tmp);
	}
	return $tmp;
}

?>
