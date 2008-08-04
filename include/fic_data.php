<?php
/*
 *  fic_data.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_data
 *  Given a fic_id, get its data from 'fics' - comments, file, text, etc
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_data($id)
{
	global $tables;
	return DBGetRow("SELECT * FROM " . $tables['fics'] . " WHERE fic_id = $id");
}

?>
