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

function readfic($id)
{
	global $codex_conf, $spellcheck, $tables, $tpl;
	$tpl->clear_all_assign();
	if (isset($id)) {
		$fic = DBGetRow("SELECT fic_data, fic_file FROM " . $tables['fics'] . " WHERE fic_id = " . $id);
		if ($fic) {
			$fdat = $fic['fic_data'];
			/*
			 * Use the file version if it exists
			 */
			if (isset($fic['fic_file']) && file_exists($codex_conf['basepath'] . $fic['fic_file']))
				$fdat = file_get_contents($codex_conf['basepath'] . $fic['fic_file']);
				
			/*
			 * Spellcheck
			 */
			if ($codex_conf['spellcheck'] == TRUE)
				foreach ($spellcheck as $broke => $fixed)
					$fdat = ereg_replace($broke,$fixed,$fdat);

			/*
			 * Fix for display on web browsers
			 */
			$fdat = htmlentities($fdat,ENT_COMPAT,'UTF-8');
			$fdat = nl2br($fdat);
		} else
			$fdat = "Invalid fic";
	} else
		$fdat = "No fic specified";
	$tpl->assign("fdata",$fdat);
	$tpl->display("read.tpl");
}

?>
