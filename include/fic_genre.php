<?php
/*
 *  fic_genre.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_genre
 *  Given a fic_id, get a list of its genres
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_genre($id)
{
	global $tables, $cache;
	
	$tmp = $cache->Get("fic_genre_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT t2.* FROM " . $tables['fic_genre'] . " AS t1, " . $tables['genres'] . " AS t2 WHERE t1.fic_id = $id AND t1.genre_id = t2.genre_id ORDER BY t2.genre_name");
		$cache->Set("fic_genre_" . $id, $tmp);
	}
	return $tmp;
}

?>
