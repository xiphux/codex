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
	global $tables, $cache;
	
	$tmp = $cache->Get("fic_data_" . $id);
	if (!$tmp) {
		$tmp = DBGetRow("SELECT fic_id,fic_title,fic_comments FROM " . $tables['fics'] . " WHERE fic_id = $id");
		$cache->Set("fic_data_" . $id, $tmp);
	}
	return $tmp;
}

?>
