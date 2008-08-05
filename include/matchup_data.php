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
	global $tables;
	return DBGetRow("SELECT m1.matchup_id, char1.character_name AS match1, char1.character_id AS id1, char2.character_name AS match2, char2.character_id AS id2, CONCAT(char1.character_name,' + ',char2.character_name) AS matchup_name FROM " . $tables['matchups'] . " AS m1 LEFT JOIN " . $tables['characters'] . " AS char1 ON char1.character_id = m1.match_1 LEFT JOIN " . $tables['characters'] . " AS char2 ON char2.character_id = m1.match_2 WHERE m1.matchup_id = " . $id);
}

?>
