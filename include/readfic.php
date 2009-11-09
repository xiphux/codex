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

include_once('fic_exists.php');
include_once('chapter_count.php');
include_once('readchapter.php');
include_once('toc.php');
include_once('chapter_exists.php');
include_once('increment_viewcount.php');

function readfic($id, $ch = 0)
{
	global $cache;

	$outkey = "readfic_" . $id . "_" . $ch;

	$chapcount = chapter_count($id);

	$out = $cache->Get($outkey);
	if (!$out) {
		if (isset($id)) {
			if (fic_exists($id)) {
				if ($ch == 0) {
					if ($chapcount < 2)
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
	if (($id > 0) && ($chapcount > 0) && ($ch > 0)) {
		if ($chapcount < 2)
			$ch = 1;
		if (chapter_exists($id, $ch))
			increment_viewcount($id, $ch);
	}
	return $out;
}

?>
