<?php
/*
 *  db.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Database library
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 *  $Id: db.php 539 2006-05-05 04:51:58Z xiphux $
 */
 include_once('config.inc.php');
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
