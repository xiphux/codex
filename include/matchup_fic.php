<?php
/*
 *  matchup_fic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: matchup_fic
 *  Given a matchup_id, get a list of fics that use it
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function matchup_fic($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("matchup_fic_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT t2.* FROM " . $tables['fic_matchup'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.id AND t1.matchup_id = $id ORDER BY t2.title");
		$cache->Set("matchup_fic_" . $id, $tmp);
	}
	return $tmp;
}

?>
