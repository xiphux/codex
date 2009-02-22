<?php
/*
 *  readchapter.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: readchapter
 *  Display a particular chapter for reading
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

include_once('fic_data.php');
include_once('fic_author.php');
include_once('fic_chapters.php');
include_once('chapter_exists.php');
include_once('chapter_title.php');

function readchapter($id, $ch = 1)
{
	global $tpl, $cache, $tables, $spellcheck, $codex_conf;

	$outkey = "readchapter_" . $id . "_" . $ch;

	$out = $cache->Get($outkey);
	if (!$out) {
		$ctest = chapter_exists($id, $ch);
		if ($ctest) {
			$tpl->clear_all_assign();
			$tpl->assign("fic", fic_data($id));
			$tpl->assign("chapter",$ch);
			$tpl->assign("chaptitle",chapter_title($id,$ch));

			$auth = fic_author($id);
			$tpl->assign("author",$auth);

			$chapters = fic_chapters($id);
			$chapcount = count($chapters);
			$tpl->assign("chapcount",$chapcount);
			$tpl->assign("chapters",$chapters);

			$chapdata = $cache->Get("chapdata_" . $id . "_" . $ch);
			if (!$chapdata) {
				$chapdata = DBGetRow("SELECT file,data,wrapped FROM " . $tables['chapters'] . " WHERE fic=" . $id . " AND num=" . $ch);
				$cache->Set("chapdata_" . $id . "_" . $ch, $chapdata);
			}

			/*
			 * Use the file version if it exists
			 */
			if (isset($chapdata['file']) && file_exists($codex_conf['basepath'] . $chapdata['file']))
				$fdat = file_get_contents($codex_conf['basepath'] . $chapdata['file']);
			else
				$fdat = $chapdata['data'];
				
			/*
			 * Spellcheck
			 */
			if ($codex_conf['spellcheck'] == TRUE)
				foreach ($spellcheck as $broke => $fixed)
					$fdat = ereg_replace($broke,$fixed,$fdat);
		
			/*
			 * Unwrap if specified
			 */
			if ($codex_conf['unwrap'] && isset($chapdata['wrapped']) && ($chapdata['wrapped'] === "1"))
				$fdat = ereg_replace("([^\n])\r\n([^\r])","\\1 \\2",$fdat);

			/*
			 * Fix for display on web browsers
			 */
			$fdat = htmlentities($fdat,ENT_COMPAT,'UTF-8');
			$fdat = nl2br($fdat);

			$tpl->assign("fdata", $fdat);
			$out = $tpl->fetch("read.tpl");
		} else
			$out = "Invalid chapter";

		$cache->Set($outkey, $out);
	}
	return $out;
}

?>
