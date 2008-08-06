<?php
/*
 *  cache.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Cache base
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

 $cache = null;
 if ($codex_conf['cachetype'] == "memcache" && function_exists("memcache_get")) {
 	include_once('cache.memcache.php');
	$cache = new Codex_Cache_Memcache($codex_conf['memcached_address'], $codex_conf['memcached_port'], $codex_conf['memcached_persist']);
 } else if ($codex_conf['cachetype'] == "eaccelerator" && function_exists("eaccelerator_get")) {
 	include_once('cache.eaccelerator.php');
	$cache = new Codex_Cache_Eaccelerator();
 } else if ($codex_conf['cachetype'] == "filecache") {
 	include_once('cache.filecache.php');
	$cache = new Codex_Cache_Filecache($codex_conf['filecache_dir']);
 } else {
 	include_once('cache.null.php');
	$cache = new Codex_Cache_Null();
 }

?>
