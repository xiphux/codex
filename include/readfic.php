<?php
/*
 *  readfic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: readfic
 *  Search for a string
 *  Display a particular fic for reading
 *  Will use the (ideally most updated) text file if present
 *  Otherwise will use inline database version
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 include_once('fic_data.php');
 include_once('fic_author.php');
 include_once('chapter_title.php');

function readfic($id, $ch = 1)
{
	global $codex_conf, $spellcheck, $tables, $tpl, $cache;
	$tpl->clear_all_assign();
	if (isset($id)) {
		$fic = fic_data($id);
		if ($fic) {
			$ctest = chapter_title($id, $ch);
			if ($ctest) {
				$tpl->assign("fic",$fic);
				$tpl->assign("ficid",$id);
				$tpl->assign("chapter",$ch);

				$auth = fic_author($id);
				$tpl->assign("author",$auth);

				$chapters = $cache->get("chapters_" . $id);
				if (!$chapters) {
					$chapters = DBGetArray("SELECT num,title FROM " . $tables['chapters'] . " WHERE fic = " . $id . " ORDER BY num");
					$cache->set("chapters_" . $id, $chapters);
				}
				$chapcount = count($chapters);
				$tpl->assign("chapters",$chapters);
				if ($ch > 1)
					$tpl->assign("prev",($ch - 1));
				if ($ch < $chapcount)
					$tpl->assign("next",($ch + 1));

				$chapdata = $cache->get("chapdata_" . $id . "_" . $ch);
				if (!$chapdata) {
					$chapdata = DBGetRow("SELECT file,data,wrapped FROM " . $tables['chapters'] . " WHERE fic=" . $id . " AND num=" . $ch);
					$cache->set("chapdata_" . $id . "_" . $ch, $chapdata);
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
					$fdat = ereg_replace("([^\n])\r\n([^\r])","\\1\\2",$fdat);

				/*
				 * Fix for display on web browsers
				 */
				$fdat = htmlentities($fdat,ENT_COMPAT,'UTF-8');
				$fdat = nl2br($fdat);
			} else
				$fdat = "Invalid chapter";
		} else
			$fdat = "Invalid fic";
	} else
		$fdat = "No fic specified";
	$tpl->assign("fdata",$fdat);
	$tpl->display("read.tpl");
}

?>
