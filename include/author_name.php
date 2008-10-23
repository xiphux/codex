<?php
/*
 *  author_name.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: author_name
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function author_name($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("author_name_" . $id);
	if (!$tmp) {
		$tmp = DBGetOne("SELECT author_name FROM " . $tables['authors'] . " WHERE author_id = $id");
		$cache->Set("author_name_" . $id, $tmp);
	}
	return $tmp;
}

?>
