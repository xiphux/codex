<?php
/*
 *  author_name.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: author_name
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function author_name($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetOne($codex_conf['secs2cache'],"SELECT author_name FROM " . $tables['authors'] . " WHERE author_id = $id");
}

?>
