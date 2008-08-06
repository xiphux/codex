<?php
/*
 *  fic_title.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_title
 *  Given a fic_id, get its title
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_title($id)
{
	global $tables, $cache;

	$tmp = $cache->get("fic_title_" . $id);
	if (!$tmp) {
		$tmp = DBGetOne("SELECT fic_title FROM " . $tables['fics'] . " WHERE fic_id = $id");
		$cache->set("fic_title_" . $id, $tmp);
	}
	return $tmp;
}

?>
