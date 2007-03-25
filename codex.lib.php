<?php
/*
 *  codex.lib.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Function library
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
 */
 define('CODEX_TITLE',1);
 define('CODEX_AUTHOR',2);
 define('CODEX_SERIES',4);
 define('CODEX_GENRE',8);
 define('CODEX_MATCHUP_1',16);
 define('CODEX_MATCHUP_2',32);

/*
 * fic_author($id)
 * Given a fic_id, get the author(s)
 */
function fic_author($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_author'] . " AS t1, " . $tables['authors'] . " AS t2 WHERE t1.fic_id = $id AND t1.author_id = t2.author_id ORDER BY t2.author_name");
}

/*
 * author_fic($id)
 * Given an author_id, get list of
 * fics by that person
 */
function author_fic($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_author'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.fic_id AND t1.author_id = $id ORDER BY t2.fic_title");
}

/*
 * fic_genre($id)
 * Given a fic_id, get a list of its genres
 */
function fic_genre($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_genre'] . " AS t1, " . $tables['genres'] . " AS t2 WHERE t1.fic_id = $id AND t1.genre_id = t2.genre_id ORDER BY t2.genre_name");
}

/*
 * genre_fic($id)
 * Given a genre_id, return fics that classify
 */
function genre_fic($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_genre'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.fic_id AND t1.genre_id = $id ORDER BY t2.fic_title");
}

/*
 * fic_series($id)
 * Given a fic_id, get a list of its series
 */
function fic_series($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_series'] . " AS t1, " . $tables['series'] . " AS t2 WHERE t1.fic_id = $id AND t1.series_id = t2.series_id ORDER BY t2.series_title");
}

/*
 * series_fic($id)
 * Given a series_id, get a list of
 * fics that use it
 */
function series_fic($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_series'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.fic_id AND t1.series_id = $id ORDER BY t2.fic_title");
}

/*
 * fic_matchup($id)
 * Given a fic_id, get the matchup characters for it
 */
function fic_matchup($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT " . $tables['matchups'] . ".matchup_id, table1.character_name match1, table1.character_id id1, table2.character_name match2, table2.character_id id2 FROM (" . $tables['characters'] . " AS table1, " . $tables['characters'] . " AS table2) JOIN " . $tables['matchups'] . " ON (" . $tables['matchups'] . ".match_1 = table1.character_id AND " . $tables['matchups'] . ".match_2 = table2.character_id) JOIN " . $tables['fic_matchup'] . " ON (" . $tables['matchups'] . ".matchup_id = " . $tables['fic_matchup'] . ".matchup_id AND " . $tables['fic_matchup'] . ".fic_id = $id)");
}

/*
 * matchup_fic($id)
 * Given a matchup_id, get a list of fics that use it
 */
function matchup_fic($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetArray($codex_conf['secs2cache'],"SELECT t2.* FROM " . $tables['fic_matchup'] . " AS t1, " . $tables['fics'] . " AS t2 WHERE t1.fic_id = t2.fic_id AND t1.matchup_id = $id ORDER BY t2.fic_title");
}

/*
 * fic_data($id)
 * Given a fic_id, get its data from 'fics' - comments, file, text, etc
 */
function fic_data($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetRow($codex_conf['secs2cache'],"SELECT * FROM " . $tables['fics'] . " WHERE fic_id = $id");
}

/*
 * fic_title($id)
 * Given a fic_id, get its title
 */
function fic_title($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetOne($codex_conf['secs2cache'],"SELECT fic_title FROM " . $tables['fics'] . " WHERE fic_id = $id");
}

/*
 * matchup_data($id)
 * Given a matchup_id, get the character names,
 * character ids, and concatenated 'A + B' string
 */
function matchup_data($id)
{
	global $db,$tables,$codex_conf;
	$tmp["match1"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_name FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_1 AND t1.matchup_id = $id");
	$tmp["match2"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_name FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_2 AND t1.matchup_id = $id");
	$tmp["id1"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_id FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_1 AND t1.matchup_id = $id");
	$tmp["id2"] = $db->CacheGetOne($codex_conf['secs2cache'],"SELECT t2.character_id FROM " . $tables['matchups'] . " AS t1, " . $tables['characters'] . " AS t2 WHERE t2.character_id = t1.match_2 AND t1.matchup_id = $id");
	$tmp["matchup_name"] = $tmp['match1'] . " + " . $tmp['match2'];
	return $tmp;
}

/*
 * character_series($id)
 * Given a character_id, get the series
 * he/she is from
 */
function character_series($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetOne($codex_conf['secs2cache'],"SELECT series_id FROM " . $tables['characters_series'] . " WHERE character_id = $id");
}

/*
 * series_title($id)
 * Given a series_id, get its title
 */
function series_title($id)
{
	global $db,$tables,$codex_conf;
	return $db->CacheGetOne($codex_conf['secs2cache'],"SELECT series_title FROM " . $tables['series'] . " WHERE series_id = $id");
}

/*
 * matchupcmp($a,$b)
 * Compare the concatenated strings of two matchups
 */
function matchupcmp($a, $b)
{
	$m1 = matchup_data($a["matchup_id"]);
	$m2 = matchup_data($b["matchup_id"]);
	return strcmp($m1["matchup_name"],$m2["matchup_name"]);
}

/*
 * highlight(&$string, $substr, $type = "searchtext")
 * Highlight a substring in another string with a <span> tag
 */
function highlight(&$string, $substr, $type = "searchtext")
{
	$string = "<span>" . $string . "</span>";
	$string = eregi_replace("(>[^<]*)(" . quotemeta($substr) . ")","\\1<span class=\"" . $type . "\">\\2</span>",$string);
	$string = eregi_replace("<span>","",$string);
	$string = substr($string,0,-7);
}

/*
 * printfic($id)
 * Print out a fic's information given a fic id
 */
function printfic($id, $author_info = TRUE, $highlight = 0, $search = null)
{
	global $tpl,$db,$codex_conf;

	/*
	 * Get the fic data
	 */
	$fdata = fic_data($id);

	/*
	 * Clear out old assigns
	 */
	$tpl->clear_all_assign();

	/*
	 * Export the fic_id for the href
	 */
	$tpl->assign("fic_id",$id);

	/*
	 * Highlight search string in title if specified
	 */
	if ($highlight == CODEX_TITLE && $search)
		highlight($fdata["fic_title"],$search);

	/*
	 * Export fic title
	 */
	$tpl->assign("fic_title",$fdata["fic_title"]);

	/*
	 * Get author data
	 */
	$adata = fic_author($id);

	/*
	 * Omit the author's contact info (for author-based listings)
	 */
	if (!$author_info) {
		foreach ($adata as $i => $aid) {
			unset($adata[$i]['author_email']);
			unset($adata[$i]['author_website']);
		}
	}

	/*
	 * Highlight a search string in author name if specified
	 */
	if ($highlight == CODEX_AUTHOR && $search) {
		foreach ($adata as $i => $aid)
			highlight($adata[$i]["author_name"],$search);
	}

	/*
	 * Export author(s)
	 */
	$tpl->assign("fic_author",$adata);

	/*
	 * Get series data
	 */
	$sdata = fic_series($id);

	/*
	 * Highlight search string in series if specified
	 */
	if ($highlight == CODEX_SERIES && $search) {
		foreach ($sdata as $i => $sid)
			highlight($sdata[$i]["series_title"],$search);
	}

	/*
	 * Export series
	 */
	$tpl->assign("fic_series",$sdata);

	/*
	 * Get genre data
	 */
	$gdata = fic_genre($id);
	
	foreach ($gdata as $i => $gid) {
		/*
		 * Mark if genre is lemon
		 */
		highlight($gdata[$i]["genre_name"],"Lemon","lemontext");

		/*
		 * Highlight search string in genre if specified
		 */
		if ($highlight == CODEX_GENRE && $search)
			highlight($gdata[$i]["genre_name"],$search);

		/*
		 * If lemons are disabled, don't finish displaying
		 */
		if (!$codex_conf['lemons'] && stristr($gdata[$i]["genre_name"],"Lemon"))
			return;
	}

	/*
	 * Export genre data
	 */
	$tpl->assign("fic_genre",$gdata);

	/*
	 * Get matchup data
	 */
	$mdata = fic_matchup($id);
	
	foreach($mdata as $i => $mid) {
		/*
		 * Highlight first character if specified
		 */
		if ($highlight == CODEX_MATCHUP_1 && $search)
			highlight($mdata[$i]["match1"],$search);

		/*
		 * Highlight second character if specified
		 */
		if ($highlight == CODEX_MATCHUP_2 && $search)
			highlight($mdata[$i]["match2"],$search);

		/*
		 * Get series for each character
		 */
		$s1 = character_series($mdata[$i]["id1"]);
		$s2 = character_series($mdata[$i]["id2"]);

		/*
		 * If it's a crossover matchup, say what series each character is from
		 */
		if ($s1 != $s2) {
			$mdata[$i]["match1"] .= " (" . series_title($s1) . ")";
			$mdata[$i]["match2"] .= " (" . series_title($s2) . ")";
		}
	}

	/*
	 * Export matchup data
	 */
	$tpl->assign("fic_matchup",$mdata);

	/*
	 * Export comments if any
	 */
	if ($fdata["fic_comments"])
		$tpl->assign("fic_comments",$fdata["fic_comments"]);

	/*
	 * Display template
	 */
	$tpl->display("entry.tpl");
}

/*
 * listfics($sort, $id)
 * List fics given a particular sort criteria
 */
function listfics($sort = "title", $searchid = null, $highlight = 0, $searchstring = null)
{
	global $codex_conf,$db,$tpl,$tables;

	/*
	 * Sort by genre
	 */
	if ($sort == "genre") {
		$q = "SELECT * FROM " . $tables['genres'];

		/*
		 * User only wants one genre
		 */
		if (isset($searchid))
			$q .= " WHERE genre_id = $searchid";
		else
			$q .= " ORDER BY genre_name";
		$gl = $db->CacheGetArray($codex_conf['secs2cache'],$q);

		/*
		 * Enumerate genre list
		 */
		foreach ($gl as $row) {
			if (!stristr($row['genre_name'],"Lemon") || $codex_conf['lemons']) {
				$tpl->clear_all_assign();
				$tpl->assign("catsort",$sort);
				$tpl->assign("catidtype","gid");
				$tpl->assign("catid",$row['genre_id']);
				highlight($row['genre_name'],"Lemon","lemontext");
				if ($highlight == CODEX_GENRE && $searchstring)
					highlight($row['genre_name'],$searchstring);
				$tpl->assign("catname",$row['genre_name']);
				$tpl->display("category.tpl");
				$fl = genre_fic($row['genre_id']);
				/*
				 * Enumerate fics per genre
				 */
				foreach ($fl as $row2)
					printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
			}
		}
	
	/*
	 * Sort by series
	 */
	} else if ($sort == "series") {
		$q = "SELECT * FROM " . $tables['series'];

		/*
		 * User only wants one series
		 */
		if (isset($searchid))
			$q .= " WHERE series_id = $searchid";
		else
			$q .= " ORDER BY series_title";
		$sl = $db->CacheGetArray($codex_conf['secs2cache'],$q);

		/*
		 * Enumerate series list
		 */
		foreach ($sl as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort",$sort);
			$tpl->assign("catidtype","sid");
			$tpl->assign("catid",$row['series_id']);
			if ($highlight == CODEX_SERIES && $searchstring)
				highlight($row['series_title'],$searchstring);
			$tpl->assign("catname",$row['series_title']);
			$tpl->display("category.tpl");
			$fl = series_fic($row['series_id']);

			/*
			 * Enumerate fics per series
			 */
			foreach ($fl as $row2)
				printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
		}
	
	/*
	 * Sort by matchup
	 */
	} else if ($sort == "matchup") {
		$q = "SELECT * FROM " . $tables['matchups'];

		/*
		 * User only wants one matchup
		 */
		if (isset($searchid))
			$q .= " WHERE matchup_id = $searchid";
		else
			$q .= " ORDER BY matchup_id";
		$ml = $db->CacheGetArray($codex_conf['secs2cache'],$q);
		usort($ml,"matchupcmp");

		/*
		 * Enumerate matchup list
		 */
		foreach ($ml as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort",$sort);
			$tpl->assign("catidtype","mid");
			$tpl->assign("catid",$row['matchup_id']);
			$tmp = matchup_data($row['matchup_id']);
			if ($highlight == CODEX_MATCHUP_1 && $searchstring)
				highlight($tmp['match1'],$searchstring);
			if ($highlight == CODEX_MATCHUP_2 && $searchstring)
				highlight($tmp['match2'],$searchstring);
			$s1 = character_series($tmp['id1']);
			$s2 = character_series($tmp['id2']);
			if ($s1 != $s2) {
				$tmp['match1'] .= " (" . series_title($s1) . ")";
				$tmp['match2'] .= " (" . series_title($s2) . ")";
			}
			$tmp["matchup_name"] = $tmp['match1'] . " + " . $tmp['match2'];
			$tpl->assign("catname",$tmp['matchup_name']);
			$tpl->display("category.tpl");
			$fl = matchup_fic($row['matchup_id']);

			/*
			 * Enumerate fics per matchup
			 */
			foreach ($fl as $row2)
				printfic($row2['fic_id'],TRUE,$highlight,$searchstring);
		}

	/*
	 * Sort by author
	 */
	} else if ($sort == "author") {
		$q = "SELECT * FROM " . $tables['authors'];

		/*
		 * User only wants one author
		 */
		if (isset($searchid))
			$q .= " WHERE author_id = $searchid";
		else
			$q .= " ORDER BY author_name";
		$al = $db->CacheGetArray($codex_conf['secs2cache'],$q);

		/*
		 * Enumerate author list
		 */
		foreach ($al as $row) {
			$tpl->clear_all_assign();
			$tpl->assign("catsort",$sort);
			$tpl->assign("catidtype","aid");
			$tpl->assign("catid",$row['author_id']);
			if ($highlight == CODEX_AUTHOR && $searchstring)
				highlight($row['author_name'],$searchstring);
			$tpl->assign("catname",$row['author_name']);
			$tpl->assign("email",$row['author_email']);
			$tpl->assign("website",$row['author_website']);
			$tpl->display("category.tpl");
			$fl = author_fic($row['author_id']);

			/*
			 * Enumerate fics per author
			 */
			foreach ($fl as $row2)
				printfic($row2['fic_id'],FALSE,$highlight,$searchstring);
		}
	
	/*
	 * Default case, sort alphabetically
	 */
	} else {
		$fl = $db->CacheGetCol($codex_conf['secs2cache'],"SELECT fic_id FROM " . $tables['fics'] . " ORDER BY fic_title");
		foreach ($fl as $row)
			printfic($row,TRUE,$highlight,$searchstring);
	}
}

/*
 * readfic($id)
 * Display a particular fic for reading
 * Will use the (ideally most updated) text file if present
 * Otherwise will use inline database version
 */
function readfic($id)
{
	global $codex_conf, $spellcheck, $db, $tpl;
	$tpl->clear_all_assign();
	if (isset($id)) {
		$fic = fic_data($id);
		if ($fic) {
			$fdat = $fic['fic_data'];
			/*
			 * Use the file version if it exists
			 */
			if (isset($fic['fic_file']) && file_exists($codex_conf['basepath'] . $fic['fic_file']))
				$fdat = file_get_contents($codex_conf['basepath'] . $fic['fic_file']);
				
			/*
			 * Spellcheck
			 */
			if ($codex_conf['spellcheck'] == TRUE)
				foreach ($spellcheck as $broke => $fixed)
					$fdat = ereg_replace($broke,$fixed,$fdat);

			/*
			 * Fix for display on web browsers
			 */
			$fdat = htmlentities($fdat,ENT_COMPAT,'UTF-8');
			$fdat = nl2br($fdat);
		} else
			$fdat = "Invalid fic";
	} else
		$fdat = "No fic specified";
	$tpl->assign("fdata",$fdat);
	$tpl->display("read.tpl");
}

/*
 * findfic()
 * Search for a string
 */
function findfic($src = null)
{
	global $db,$codex_conf,$tables;
	if (isset($src)) {
	 	$found = FALSE;

		/*
		 * Substring search fic title
		 */
		$res = $db->CacheGetArray($codex_conf['secs2cache'],"SELECT fic_id FROM " . $tables['fics'] . " WHERE UPPER(fic_title) LIKE '%" . strtoupper($src) . "%' ORDER BY fic_title");
		foreach ($res as $row) {
			$found = TRUE;
			printfic($row['fic_id'],TRUE,CODEX_TITLE,$src);
		}

		/*
		 * Substring search fic author
		 */
		$res = $db->CacheGetArray($codex_conf['secs2cache'],"SELECT author_id FROM " . $tables['authors'] . " WHERE UPPER(author_name) LIKE '%" . strtoupper($src) . "%' ORDER BY author_name");
		foreach ($res as $row) {
			$found = TRUE;
			listfics("author",$row['author_id'],CODEX_AUTHOR,$src);
		}

		/*
		 * Substring search fic series
		 */
		$res = $db->CacheGetArray($codex_conf['secs2cache'],"SELECT series_id FROM " . $tables['series'] . " WHERE UPPER(series_title) LIKE '%" . strtoupper($src) . "%' ORDER BY series_title");
		foreach ($res as $row) {
			$found = TRUE;
			listfics("series",$row['series_id'],CODEX_SERIES,$src);
		}

		/*
		 * Substring search fic genre
		 */
		$res = $db->CacheGetArray($codex_conf['secs2cache'],"SELECT genre_id FROM " . $tables['genres'] . " WHERE UPPER(genre_name) LIKE '%" . strtoupper($src) . "%' ORDER BY genre_name");
		foreach ($res as $row) {
			$found = TRUE;
			listfics("genre",$row['genre_id'],CODEX_GENRE,$src);
		}

		/*
		 * Substring search fic characters/matchups
		 */
		$res = $db->CacheGetArray($codex_conf['secs2cache'],"SELECT character_id FROM " . $tables['characters'] . " WHERE UPPER(character_name) LIKE '%" . strtoupper($src) . "%' ORDER BY character_name");
		/*
		 * Already listed matchups array
		 */
		$ex = array();
		foreach ($res as $row) {
			/*
			 * Get matchups for character 1
			 */
			$r = $db->CacheGetArray($codex_conf['secs2cache'],"SELECT matchup_id FROM " . $tables['matchups'] . " WHERE match_1 = " . $row['character_id']);

			/*
			 * Sort alphabetically
			 */
			usort($r,"matchupcmp");
			foreach ($r as $row2) {
				/*
				 * If not shown, list
				 */
				if (!in_array($row2['matchup_id'],$ex)) {
					$found = TRUE;
					$ex[] = $row2['matchup_id'];
					listfics("matchup",$row2['matchup_id'],CODEX_MATCHUP_1,$src);
				}
			}

			/*
			 * Get matchups for character 2
			 */
			$r = $db->CacheGetArray($codex_conf['secs2cache'],"SELECT matchup_id FROM " . $tables['matchups'] . " WHERE match_2 = {$row['character_id']}");

			/*
			 * Sort alphabetically
			 */
			usort($r,"matchupcmp");

			foreach ($r as $row2) {
				/*
				 * If not shown, list
				 */
				if (!in_array($row2['matchup_id'],$ex)) {
					$found = TRUE;
					$ex[] = $row2['matchup_id'];
					listfics("matchup",$row2['matchup_id'],CODEX_MATCHUP_2,$src);
				}
			}
		}
	}
}

/*
 * stats()
 * Display database statistics
 */
function stats()
{
	global $codex_conf,$version,$db,$tpl,$tables;
	$tpl->clear_all_assign();
	$tpl->assign("appstring","Codex $version");
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
	$tpl->assign("fics",sizeof($db->CacheGetArray($codex_conf['secs2cache'],"SELECT fic_id FROM " . $tables['fics'])));
	$tpl->assign("authors",sizeof($db->CacheGetArray($codex_conf['secs2cache'],"SELECT author_id FROM " . $tables['authors'])));
	$tpl->assign("genres",sizeof($db->CacheGetArray($codex_conf['secs2cache'],"SELECT genre_id FROM " . $tables['genres'])));
	$tpl->assign("series",sizeof($db->CacheGetArray($codex_conf['secs2cache'],"SELECT series_id FROM " . $tables['series'])));
	$tpl->assign("characters",sizeof($db->CacheGetArray($codex_conf['secs2cache'],"SELECT character_id FROM " . $tables['characters'])));
	$tpl->assign("matchups",sizeof($db->CacheGetArray($codex_conf['secs2cache'],"SELECT matchup_id FROM " . $tables['matchups'])));
	$tpl->display("stats.tpl");
	$dbstats = $db->CacheGetArray($codex_conf['secs2cache'],"SHOW TABLE STATUS");
	$total = 0;
	foreach ($dbstats as $row) {
		if ($codex_conf['optimize'])
			$db->CacheExecute($codex_conf['secs2cache'],"OPTIMIZE TABLE " . $db->qstr($row['Name']));
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

/*
 * dbperfmon()
 * Display adodb performance monitoring
 */
function dbperfmon()
{
	global $codex_conf,$db;
	session_start();
	$perf =& NewPerfMonitor($db);
	$perf->UI($pollsecs=5);
}
?>
