<?php
/*
 *  fic_chapters.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_chapters
 *  Get a list of a fic's chapters
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_chapters($id)
{
	global $tables, $cache;

	$outkey = "fic_chapters_" . $id;

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = DBGetArray("SELECT num,title FROM " . $tables['chapters'] . " WHERE fic = " . $id . " ORDER BY num");
		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
