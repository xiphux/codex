<?php
/*
 *  chapter_title.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: chapter_title
 *  Given a fic_id and chapter id, get the title
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

function chapter_title($fic, $ch)
{
	global $tables, $cache;
	
	$tmp = $cache->Get("chapter_title_" . $fic . "_" . $ch);
	if (!$tmp) {
		$tmp = null;
		$chap = DBGetRow("SELECT id,title FROM " . $tables['chapters'] . " WHERE fic=" . $fic . " AND num=" . $ch);
		if ($chap) {
			if ($chap['title'])
				$tmp = $chap['title'];
			else
				$tmp = "Chapter " . $ch;
		}
		if ($tmp)
			$cache->Set("chapter_title_" . $fic . "_" . $ch, $tmp);
	}
	return $tmp;
}

?>
