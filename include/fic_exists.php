<?php
/*
 * fic_exists.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: fic_exists
 * Given a fic_id, returns whether the fic exists
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */

function fic_exists($id)
{
	global $tables, $cache;

	if (!$id)
		return false;

	$tmp = $cache->Get("fic_exists_" . $id);
	if (!$tmp) {
		$tmp = false;
		$fic = DBGetRow("SELECT id FROM " . $tables['fics'] . " WHERE id=" . $id);
		if ($fic)
			$tmp = true;
		if (isset($tmp))
			$cache->Set("fic_exists_" . $id, $tmp);
	}
	return $tmp;
}

?>
