<?php
/*
 *  author_fic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: author_fic
 *  Given an author_id, get list of
 *  fics by that person
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function author_fic($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_author'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.fic_id AND t1.author_id = $id ORDER BY t2.fic_title");
}

?>
