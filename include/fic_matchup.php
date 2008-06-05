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
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT " . $tables['matchups'] . ".matchup_id, table1.character_name match1, table1.character_id id1, table2.character_name match2, table2.character_id id2 FROM (" . $tables['characters'] . " AS table1, " . $tables['characters'] . " AS table2) JOIN " . $tables['matchups'] . " ON (" . $tables['matchups'] . ".match_1 = table1.character_id AND " . $tables['matchups'] . ".match_2 = table2.character_id) JOIN " . $tables['fic_matchup'] . " ON (" . $tables['matchups'] . ".matchup_id = " . $tables['fic_matchup'] . ".matchup_id AND " . $tables['fic_matchup'] . ".fic_id = $id)");
}

?>
