<?php
/*
 *  chapter_exists.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: chapter_exists
 *  Given a fic_id and chapter id, return whether the chapter exists
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

function chapter_exists($fic, $ch)
{
	global $tables, $cache;
	
	$tmp = $cache->Get("chapter_exists_" . $fic . "_" . $ch);
	if (!$tmp) {
		$tmp = false;
		$chap = DBGetRow("SELECT id FROM " . $tables['chapters'] . " WHERE fic=" . $fic . " AND num=" . $ch);
		if ($chap)
			$tmp = true;
		if (isset($tmp))
			$cache->Set("chapter_exists_" . $fic . "_" . $ch, $tmp);
	}
	return $tmp;
}

?>
