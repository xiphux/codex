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
	global $tables;
	return DBGetOne("SELECT series_id FROM " . $tables['characters_series'] . " WHERE character_id = $id");
}

?>
