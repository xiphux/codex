<?php
/*
 *  series_fic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: series_fic
 *  Given a series_id, get a list of
 *  fics that use it
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function series_fic($id)
{
	global $tables, $cache;

	$tmp = $cache->Get("series_fic_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT t2.* FROM " . $tables['fic_series'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.id AND t1.series_id = $id ORDER BY t2.title");
		$cache->Set("series_fic_" . $id, $tmp);
	}
	return $tmp;
}

?>
