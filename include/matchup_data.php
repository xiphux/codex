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
	global $db,$tables,$codex_conf;
	$tmp["match1"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_name FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_1 AND t1.matchup_id = $id");
	$tmp["match2"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_name FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_2 AND t1.matchup_id = $id");
	$tmp["id1"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_id FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_1 AND t1.matchup_id = $id");
	$tmp["id2"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_id FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_2 AND t1.matchup_id = $id");
	$tmp["matchup_name"] = $tmp['match1'] . " + " . $tmp['match2'];
	return $tmp;
}

?>
