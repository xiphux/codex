<?php
/*
 *  readfic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: readfic
 *  Display a particular fic for reading
 *  Will use the (ideally most updated) text file if present
 *  Otherwise will use inline database version
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('fic_data.php');
include_once('chapter_count.php');
include_once('readchapter.php');
include_once('toc.php');

function readfic($id, $ch = 0)
{
	global $cache;

	$outkey = "readfic_" . $id . "_" . $ch;

	$out = $cache->Get($outkey);
	if (!$out) {
		if (isset($id)) {
			if (fic_data($id)) {
				if ($ch == 0) {
					if (chapter_count($id) < 2)
						$out = readchapter($id, 1);
					else
						$out = toc($id);
				} else
					$out = readchapter($id, $ch);
			} else
				$out = "Invalid fic";
		} else
			$out = "No fic specified";

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
