<?php
/*
 * increment_viewcount.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: increment_viewcount
 * Increment the view count of a chapter
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function increment_viewcount($fic, $ch)
{
	global $tables;

	if (!(isset($fic) && isset($ch)))
		return;

	if (!(is_numeric($fic) && is_numeric($ch)))
		return;

	if (($fic < 1) || ($ch < 1))
		return;

	return DBExecute("UPDATE " . $tables['chapters'] . " SET views=views+1 WHERE fic=" . $fic . " AND num=" . $ch);
}

?>
