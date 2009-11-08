<?php
/*
 *  series_title.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: series_title
 *  Given a series_id, get its title
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function series_title($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("series_title_" . $id);
	if (!$tmp) {
		$tmp = DBGetOne("SELECT title FROM " . $tables['series'] . " WHERE id = $id");
		$cache->Set("series_title_" . $id, $tmp);
	}
	return $tmp;
}

?>
