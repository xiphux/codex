<?php
/*
 *  genre_fic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: genre_fic
 *  Given a genre_id, return fics that classify
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function genre_fic($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("genre_fic_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT t2.id, t2.title, t2.sequel_to, t2.sidestory_to, t2.comments FROM " . $tables['fic_genre'] . " AS t1 LEFT JOIN " . $tables['fics'] . " AS t2 ON t1.fic_id = t2.id WHERE t1.genre_id = $id ORDER BY t2.title");
		$cache->Set("genre_fic_" . $id, $tmp);
	}
	return $tmp;
}

?>
