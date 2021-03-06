<?php
/*
 *  fic_author.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_author
 *  Given a fic_id, get the author(s)
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_author($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("fic_author_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT t2.id, t2.name, t2.email, t2.website FROM " . $tables['fic_author'] . " AS t1 LEFT JOIN " . $tables['authors'] . " AS t2 ON t1.author_id = t2.id WHERE t1.fic_id = $id AND ((t2.name IS NOT NULL) OR (t2.email IS NOT NULL)) ORDER BY t2.name");
		$cache->Set("fic_author_" . $id, $tmp);
	}
	return $tmp;
}

?>
