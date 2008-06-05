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
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_genre'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.fic_id AND t1.genre_id = $id ORDER BY t2.fic_title");
}

?>
