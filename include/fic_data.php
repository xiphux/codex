<?php
/*
 *  fic_data.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: fic_data
 *  Given a fic_id, get its data from 'fics' - comments, file, text, etc
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function fic_data($id)
{
	global $tables, $cache;
	
	$tmp = $cache->Get("fic_data_" . $id);
	if (!$tmp) {
		$tmp = DBGetRow("SELECT t1.id,t1.title,t1.sequel_to,t1.sidestory_to,t1.comments,t2.title as sequel_to_title,t3.title as sidestory_to_title FROM " . $tables['fics'] . " AS t1 LEFT JOIN " . $tables['fics'] . " AS t2 ON t2.id = t1.sequel_to LEFT JOIN " . $tables['fics'] . " AS t3 ON t3.id = t1.sidestory_to WHERE t1.id = $id");
		if (isset($tmp['id'])) {
			$sstories = DBGetArray("SELECT id,title FROM " . $tables['fics'] . " WHERE sidestory_to = " . $tmp['id'] . " ORDER BY title");
			if (isset($sstories) && (count($sstories) > 0))
				$tmp['sidestories'] = $sstories;
			$sequels = DBGetArray("SELECT id,title FROM " . $tables['fics'] . " WHERE sequel_to = " . $tmp['id'] . " ORDER BY title");
			if (isset($sequels) && (count($sequels) > 0))
				$tmp['sequels'] = $sequels;
		}
		$cache->Set("fic_data_" . $id, $tmp);
	}
	return $tmp;
}

?>
