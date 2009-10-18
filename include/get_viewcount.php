<?php
/*
 * get_viewcount.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: get_viewcount
 * Gets the view count of a chapter
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function get_viewcount($fic, $ch)
{
	global $tables;

	if (!(isset($fic) && isset($ch)))
		return;

	if (!(is_numeric($fic) && is_numeric($ch)))
		return;

	if (($fic < 1) || ($ch < 1))
		return;

	return DBGetOne("SELECT views FROM " . $tables['chapters'] . " WHERE fic=" . $fic . " AND num=" . $ch);
}

?>
