<?php
/*
 *  matchup_data.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: matchup_data
 *  Given a matchup_id, get the character names,
 *  character ids, and concatenated 'A + B' string
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function matchup_data($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("matchup_data_" . $id);
	if (!$tmp) {
		$tmp = DBGetRow("SELECT m1.id, char1.name AS match1, char1.id AS id1, char2.name AS match2, char2.id AS id2, s1.id as sid1, s2.id as sid2, s1.title as title1, s2.title as title2, IF(s1.id=s2.id,CONCAT(char1.name,' + ',char2.name,' (',s1.title,')'),CONCAT(char1.name,' (',s1.title,') + ',char2.name,' (',s2.title,')')) AS matchup_name FROM " . $tables['matchups'] . " AS m1 LEFT JOIN " . $tables['characters'] . " AS char1 ON char1.id = m1.character1 LEFT JOIN " . $tables['characters'] . " AS char2 ON char2.id = m1.character2 LEFT JOIN " . $tables['characters_series'] . " AS cs1 ON char1.id = cs1.character_id LEFT JOIN " . $tables['series'] . " AS s1 ON cs1.series_id = s1.id LEFT JOIN " . $tables['characters_series'] . " AS cs2 ON char2.id = cs2.character_id LEFT JOIN " . $tables['series'] . " AS s2 ON cs2.series_id = s2.id WHERE m1.id = " . $id);
		$cache->Set("matchup_data_" . $id, $tmp);
	}
	return $tmp;
}

?>
