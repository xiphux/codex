<?php
/*
 *  printfic.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: printfic
 *  Print out a fic's information given a fic id
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function printcategory($catsort, $catidtype, $catid, $catname, $email = null, $website = null)
{
	global $cache, $tpl;

	$key = "output_printcategory_" . $catsort . "_" . $catidtype . "_" . $catid . "_" . $catname . "_" . $email . "_" . $website;

	$out = $cache->get($key);
	if (!$out) {
		$tpl->clear_all_assign();
		$tpl->assign("catsort", $catsort);
		$tpl->assign("catidtype", $catidtype);
		$tpl->assign("catid", $catid);
		$tpl->assign("catname", $catname);
		if ($email)
			$tpl->assign("email", $email);
		if ($website)
			$tpl->assign("website", $website);
		$out = $tpl->fetch("category.tpl");
		$cache->set($key, $out);
	}
	return $out;
}

?>