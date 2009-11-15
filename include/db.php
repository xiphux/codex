<?php
/*
 *  db.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Database library
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 include_once($codex_conf['adodb_prefix'] . "adodb.inc.php");

$tables = array();
$tables['authors'] = $codex_conf['prefix'] . "authors";
$tables['chapters'] = $codex_conf['prefix'] . "chapters";
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

if ($codex_conf['debug'])
	$db->debug = TRUE;

$querycount = 0;

function DBExecute($sql,$inputarr=false)
{
	global $db,$querycount,$codex_conf;
	++$querycount;
	$ret = $db->Execute($sql,$inputarr);
	if ($codex_conf['adodbcache'])
		$db->CacheFlush();
	return $ret;
}

function DBqstr($s,$magic_quotes_enabled=false)
{
	global $db;
	return $db->qstr($s,$magic_quotes_enabled);
}

function DBGetOne($sql,$inputarr=false)
{
	global $db,$querycount,$codex_conf;
	++$querycount;
	if ($codex_conf['adodbcache'])
		return $db->CacheGetOne($codex_conf['secs2cache'],$sql,$inputarr);
	else
		return $db->GetOne($sql,$inputarr);
}

function DBGetRow($sql,$inputarr=false)
{
	global $db,$querycount,$codex_conf;
	++$querycount;
	if ($codex_conf['adodbcache'])
		return $db->CacheGetRow($codex_conf['secs2cache'],$sql,$inputarr);
	else
		return $db->GetRow($sql,$inputarr);
}

function DBGetCol($sql,$inputarr=false)
{
	global $db,$querycount,$codex_conf;
	++$querycount;
	if ($codex_conf['adodbcache'])
		return $db->CacheGetCol($codex_conf['secs2cache'],$sql,$inputarr);
	else
		return $db->GetCol($sql,$inputarr);
}

function DBGetArray($sql,$inputarr=false)
{
	global $db,$querycount,$codex_conf;
	++$querycount;
	if ($codex_conf['adodbcache'])
		return $db->CacheGetArray($codex_conf['secs2cache'],$sql,$inputarr);
	else
		return $db->GetArray($sql,$inputarr);
}

function DBInsertID()
{
	global $db,$querycount;
	++$querycount;
	return $db->Insert_ID();
}

function DBPrepare($sql)
{
	global $db,$querycount;
	++$querycount;
	return $db->Prepare($sql);
}

function DBStartTrans()
{
	global $db,$querycount;
	++$querycount;
	return $db->StartTrans();
}

function DBCompleteTrans($autoComplete=true)
{
	global $db,$querycount;
	++$querycount;
	return $db->CompleteTrans($autoComplete);
}

function DBErrorMsg()
{
	global $db;
	return $db->ErrorMsg();
}

function DBSelectLimit($sql, $nrows=-1, $offset=-1, $inputarr=false)
{
	global $db,$querycount,$codex_conf;
	++$querycount;
	if ($codex_conf['adodbcache'])
		$ret = $db->SelectLimit($sql, $nrows, $offset, $inputarr, $codex_conf['secs2cache']);
	else
		$ret = $db->SelectLimit($sql, $nrows, $offset, $inputarr);
	return $ret;
}

?>
