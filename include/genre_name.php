<?php
/*
 *  genre_name.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: genre_name
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function genre_name($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("genre_name_" . $id);
	if (!$tmp) {
		$tmp = DBGetOne("SELECT genre_name FROM " . $tables['genres'] . " WHERE genre_id = $id");
		$cache->Set("genre_name_" . $id, $tmp);
	}
	return $tmp;
}

?>
