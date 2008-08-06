<?php
/*
 *  cache.null.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Null cache
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

class Codex_Cache_Null
{
	function Codex_Cache_Null()
	{
	}

	function cachetype()
	{
		return "null";
	}

	function get($key)
	{
		return null;
	}

	function set($key, $val)
	{
		return FALSE;
	}

	function del($key)
	{
		return FALSE;
	}

	function close()
	{
	}

	function clear()
	{
		return FALSE;
	}

	function stats()
	{
		return null;
	}

}
