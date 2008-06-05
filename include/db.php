<?php
/*
 *  db.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Database library
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */
 include_once("adodb/adodb.inc.php");

$tables = array();
$tables['authors'] = $codex_conf['prefix'] . "authors";
$tables['characters'] = $codex_conf['prefix'] . "characters";
$tables['characters_series'] = $codex_conf['prefix'] . "characters_series";
$tables['fic_author'] = $codex_conf['prefix'] . "fic_author";
$tables['fic_genre'] = $codex_conf['prefix'] . "fic_genre";
$tables['fic_matchup'] = $codex_conf['prefix'] . "fic_matchup";
$tables['fic_series'] = $codex_conf['prefix'] . "fic_series";
$tables['fics'] = $codex_conf['prefix'] . "fics";
$tables['genres'] = $codex_conf['prefix'] . "genres";
$tables['matchups'] = $codex_conf['prefix'] . "matchups";
$tables['series'] = $codex_conf['prefix'] . "series";

$db = NewADOConnection($codex_conf['db_type']);
if ($codex_conf['persist'])
	$db->PConnect($codex_conf['db_host'],$codex_conf['db_user'],$codex_conf['db_pass'],$codex_conf['database']);
else
	$db->Connect($codex_conf['db_host'],$codex_conf['db_user'],$codex_conf['db_pass'],$codex_conf['database']);
$db->SetFetchMode(ADODB_FETCH_ASSOC);

?>
