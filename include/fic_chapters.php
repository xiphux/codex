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
	global $tables, $cache, $codex_conf;

	$outkey = "fic_chapters_" . $id;

	$out = $cache->Get($outkey);
	if (!$out) {
		$out = DBGetArray("SELECT num,title,views,file,data FROM " . $tables['chapters'] . " WHERE fic = " . $id . " ORDER BY num");
		for ($i = 0; $i < count($out); $i++) {
			$fdata = null;
			if (isset($out[$i]['file']) && file_exists($codex_conf['basepath'] . $out[$i]['file']))
				$fdata = file_get_contents($codex_conf['basepath'] . $out[$i]['file']);
			else
				$fdata = $out[$i]['data'];

			$out[$i]['wordcount'] = str_word_count($fdata);

			unset($out[$i]['file']);
			unset($out[$i]['data']);
		}
		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
