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
	global $db,$tables,$codex_conf;
	return $db->CacheGetOne($codex_conf['secs2cache'],"SELECT fic_title FROM " . $tables['fics'] . " WHERE fic_id = $id");
}

?>
