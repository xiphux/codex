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
	global $tables,$cache;

	$tmp = $cache->Get("author_fic_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT t2.id, t2.title, t2.sequel_to, t2.sidestory_to, t2.comments FROM " . $tables['fic_author'] . " AS t1 LEFT JOIN " . $tables['fics'] . " AS t2 ON t1.fic_id = t2.id WHERE t1.author_id = $id ORDER BY t2.title");
		$cache->Set("author_fic_" . $id, $tmp);
	}
	return $tmp;
}

?>
