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
		$tmp = DBGetArray("SELECT t2.* FROM " . $tables['fic_author'] . " AS t1, " . $tables['authors'] . " AS t2 WHERE t1.fic_id = $id AND t1.author_id = t2.author_id ORDER BY t2.author_name");
		$cache->Set("fic_author_" . $id, $tmp);
	}
	return $tmp;
}

?>
