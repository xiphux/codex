<?php
/*
 *  stats.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: stats
 *  Display database statistics
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

function stats()
{
	global $codex_conf,$codex_version,$tpl,$tables,$cache;
	$tpl->clear_all_assign();
	$tpl->assign("appstring","Codex $codex_version");
	$tpl->assign("cdate","2005");
	$tpl->assign("cauthor_email","xiphux@gmail.com");
	$tpl->assign("cauthor","Christopher Han");
	$tpl->assign("server",getenv('SERVER_NAME'));
	$tpl->assign("uname", php_uname());
	$uptime = @exec('uptime');
	if (preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/",$uptime,$avgs)) {
		$uptime = explode(' up ', $uptime);
		$uptime = explode(',', $uptime[1]);
		$uptime = $uptime[0].', '.$uptime[1];
		$load=$avgs[1].",".$avgs[2].",".$avgs[3]."";
		$tpl->assign("uptime_days",$uptime);
		$tpl->assign("loadavg",$load);
	}
	if ($cache->GetCacheType() !== XXCACHE_NULL) {
		$tpl->assign("cachetype", $cache->GetCacheTypeString());
		$tpl->assign("cachestats", $cache->Stats());
	}
	$tpl->assign("fics",DBGetOne("SELECT COUNT(id) FROM " . $tables['fics']));
	$tpl->assign("chapters",DBGetOne("SELECT COUNT(id) FROM " . $tables['chapters']));
	$tpl->assign("authors",DBGetOne("SELECT COUNT(author_id) FROM " . $tables['authors']));
	$tpl->assign("genres",DBGetOne("SELECT COUNT(id) FROM " . $tables['genres']));
	$tpl->assign("series",DBGetOne("SELECT COUNT(series_id) FROM " . $tables['series']));
	$tpl->assign("characters",DBGetOne("SELECT COUNT(character_id) FROM " . $tables['characters']));
	$tpl->assign("matchups",DBGetOne("SELECT COUNT(matchup_id) FROM " . $tables['matchups']));
	$dbstats = DBGetArray("SHOW TABLE STATUS");
	$total = 0;
	$tablelist = array();
	foreach ($dbstats as $row) {
		if (in_array($row['Name'],$tables)) {
			if ($codex_conf['optimize'])
				DBExecute("OPTIMIZE TABLE " . $row['Name']);
			if (isset($row['Data_length']) && isset($row['Index_length'])) {
				$t = $row['Data_length'] + $row['Index_length'];
				$row['total_size'] = $t;
				$total += $t;
			}
			$tablelist[] = $row;
		}
	}
	$tpl->assign("tablelist",$tablelist);
	$tpl->assign("dbsize",$total);
	$tpl->display("stats.tpl");
}

?>
