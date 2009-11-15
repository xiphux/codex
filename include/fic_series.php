<?php
/*
 *  fic_series.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_series
 *  Given a fic_id, get a list of its series
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_series($id)
{
	global $tables, $cache;
	
	$tmp = $cache->Get("fic_series_" . $id);
	if (!$tmp) {
		$tmp = DBGetArray("SELECT t2.id, t2.title FROM " . $tables['fic_series'] . " AS t1 LEFT JOIN " . $tables['series'] . " AS t2 ON t1.series_id = t2.id WHERE t1.fic_id = $id ORDER BY t2.title");
		$cache->Set("fic_series_" . $id, $tmp);
	}
	return $tmp;
}

?>
