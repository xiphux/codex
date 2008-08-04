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
	global $codex_conf,$codex_version,$tpl,$tables;
	$tpl->clear_all_assign();
	$tpl->assign("appstring","Codex $codex_version");
	$tpl->assign("cdate","2005");
	$tpl->assign("cauthor_email","xiphux@gmail.com");
	$tpl->assign("cauthor","Christopher Han");
	$uptime = @exec('uptime');
	preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/",$uptime,$avgs);
	$uptime = explode(' up ', $uptime);
	$uptime = explode(',', $uptime[1]);
	$uptime = $uptime[0].', '.$uptime[1];
	$start=mktime(0, 0, 0, 1, 1, date("Y"), 0);
	$end=mktime(0, 0, 0, date("m"), date("j"), date("y"), 0);
	$diff=$end-$start;
	$days=$diff/86400;
	$percentage=($uptime/$days) * 100;
	$load=$avgs[1].",".$avgs[2].",".$avgs[3]."";
	$tpl->assign("server",getenv('SERVER_NAME'));
	$tpl->assign("uname",htmlentities(@exec('uname -a'),ENT_COMPAT,'UTF-8'));
	$tpl->assign("uptime_days",$uptime);
	$tpl->assign("uptime_percent",$percentage);
	$tpl->assign("loadavg",$load);
	$tpl->assign("fics",DBGetOne("SELECT COUNT(fic_id) FROM " . $tables['fics']));
	$tpl->assign("authors",DBGetOne("SELECT COUNT(author_id) FROM " . $tables['authors']));
	$tpl->assign("genres",DBGetOne("SELECT COUNT(genre_id) FROM " . $tables['genres']));
	$tpl->assign("series",DBGetOne("SELECT COUNT(series_id) FROM " . $tables['series']));
	$tpl->assign("characters",DBGetOne("SELECT COUNT(character_id) FROM " . $tables['characters']));
	$tpl->assign("matchups",DBGetOne("SELECT COUNT(matchup_id) FROM " . $tables['matchups']));
	$tpl->display("stats.tpl");
	$dbstats = DBGetArray("SHOW TABLE STATUS");
	$total = 0;
	foreach ($dbstats as $row) {
		if ($codex_conf['optimize'])
			DBExecute("OPTIMIZE TABLE " . DBqstr($row['Name']));
		$tpl->clear_all_assign();
		$tpl->assign("table",$row);
		if (isset($row['Data_length']) && isset($row['Index_length'])) {
			$t = $row['Data_length'] + $row['Index_length'];
			$tpl->assign("total_size",$t);
			$total += $t;
			$tpl->display("stats_table.tpl");
		}
	}
	$tpl->clear_all_assign();
	$tpl->assign("dbsize",$total);
	$tpl->display("stats_sum.tpl");
}

?>
