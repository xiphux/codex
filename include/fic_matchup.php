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
		$tmp = DBGetArray("SELECT " . $tables['matchups'] . ".matchup_id, table1.name match1, table1.id id1, table2.name match2, table2.id id2 FROM (" . $tables['characters'] . " AS table1, " . $tables['characters'] . " AS table2) JOIN " . $tables['matchups'] . " ON (" . $tables['matchups'] . ".match_1 = table1.id AND " . $tables['matchups'] . ".match_2 = table2.id) JOIN " . $tables['fic_matchup'] . " ON (" . $tables['matchups'] . ".matchup_id = " . $tables['fic_matchup'] . ".matchup_id AND " . $tables['fic_matchup'] . ".fic_id = $id)");
		$cache->Set("fic_matchup_" . $id, $tmp);
	}
	return $tmp;
}

?>
