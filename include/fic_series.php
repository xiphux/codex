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
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_series'] . " AS t1, " . $tables['series'] . " AS t2 WHERE t1.fic_id = $id AND t1.series_id = t2.series_id ORDER BY t2.series_title");
}

?>
