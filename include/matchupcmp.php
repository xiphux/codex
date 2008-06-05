<?php
/*
 *  matchupcmp.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: matchupcmp
 *  Compare the concatenated strings of two matchups
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function matchupcmp($a, $b)
{
	$m1 = matchup_data($a["matchup_id"]);
	$m2 = matchup_data($b["matchup_id"]);
	return strcmp($m1["matchup_name"],$m2["matchup_name"]);
}

?>
