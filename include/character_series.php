<?php
/*
 *  character_series.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: character_series
 *  Given a character_id, get the series
 *  he/she is from
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function character_series($id)
{
	global $tables, $cache;
	$tmp = $cache->Get("character_series_" . $id);
	if (!$tmp) {
		$tmp = DBGetOne("SELECT series_id FROM " . $tables['characters_series'] . " WHERE character_id = $id");
		$cache->Set("character_series_" . $id, $tmp);
	}
	return $tmp;
}

?>
