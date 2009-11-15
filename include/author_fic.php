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

function author_fic($id, $nrows=-1, $offset=-1)
{
	global $tables,$cache;

	$key = "author_fic_" . $id . "_" . $nrows . "_" . $offset;
	$tmp = $cache->Get($key);
	if (!$tmp) {
		$tmp = DBSelectLimit("SELECT t2.id, t2.title, t2.sequel_to, t2.sidestory_to, t2.comments FROM " . $tables['fic_author'] . " AS t1 LEFT JOIN " . $tables['fics'] . " AS t2 ON t1.fic_id = t2.id WHERE t1.author_id = $id ORDER BY t2.title", $nrows, $offset);
		$cache->Set($key, $tmp);
	}
	return $tmp;
}

?>
