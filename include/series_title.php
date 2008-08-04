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
	global $tables;
	return DBGetOne("SELECT series_title FROM " . $tables['series'] . " WHERE series_id = $id");
}

?>
