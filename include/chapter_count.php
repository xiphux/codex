<?php
/*
 *  chapter_count.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: author_fic
 *  Given a fic_id, get number of chapters in fic
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

function chapter_count($id)
{
	global $tables, $cache;
	
	$tmp = $cache->get("chapter_count_" . $id);
	if (!$tmp) {
		$tmp = DBGetOne("SELECT COUNT(id) FROM " . $tables['chapters'] . " WHERE fic=" . $id);
		$cache->set("chapter_count_" . $id, $tmp);
	}
	return $tmp;
}

?>
