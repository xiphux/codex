<?php
/*
 *  codex.conf.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: PHP viewer script configuration
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

 /*
  * Database connection settings
  */
 $codex_conf['db_type'] = "mysqli";
 $codex_conf['db_host'] = "localhost";
 $codex_conf['db_user'] = "codex";
 $codex_conf['db_pass'] = "hzt2xJFcsfwLw56H";
 $codex_conf['database'] = "codex";

 /*
  * Persistent database connection
  * Persistent database conections will remain
  * open and be reused, instead of reconnecting each
  * time a page loads.  However, it could cause problems
  * on a heavily loaded server with lots of connections
  * left open.
  */
 $codex_conf['persist'] = TRUE;

 /*
  * Table prefix
  * In case you have an extra string appended
  * to the front of the table names to separate
  * them from other tables, put it here.
  * So, for example, setting the prefix to
  * "codex_" would make the table names
  * "codex_fics", "codex_fic_author", etc.
  * If you don't want a prefix just leave it empty.
  */
 $codex_conf['prefix'] = "";

 /*
  * Adodb cache dir
  * Where adodb will cache its queries
  */
 $ADODB_CACHE_DIR = "cache";

 /*
  * Adodb cache timeout
  * Number of seconds a query will be cached for
  */
 $codex_conf['secs2cache'] = 10;

 /*
  * Base path containing fic text files
  * Relative to the main script in the webroot
  */
 $codex_conf['basepath'] = "fics/";

 /*
  * This is the string that will be displayed at the top of the page
  * and in the page title.  The variable '$codex_appstring' will
  * expand to the name (codex) and version.
  */
 $codex_conf['title'] = "centraldogma :: $codex_appstring";

 /*
  * If enabled, a 'stats' link will appear on the main page with
  * various system / database statistics
  */
 $codex_conf['stats'] = TRUE;

 /*
  * If enabled, the stats page will call 'OPTIMIZE' on each table
  * before displaying information
  */
 $codex_conf['optimize'] = TRUE;

 /*
  * If enabled, a database performance monitor link will appear
  * on the main page
  */
 $codex_conf['dbperfmon'] = TRUE;

 /*
  * If enabled, lemon fics will be shown.  Otherwise not
  */
 $codex_conf['lemons'] = TRUE;

 /*
  * Text color
  */
 $codex_conf['body_color'] = "white";

 /*
  * Background color
  */
 $codex_conf['background_color'] = "black";

 /*
  * Link color
  */
 $codex_conf['link_color'] = "lime";

 /*
  * Lemon color
  * Color to use to mark the lemon category.  If you don't
  * want any warning, just set the same as link color
  */
 $codex_conf['lemon_color'] = "red";

 /*
  * Spellcheck
  * If enabled, spelling will be dynamically fixed.
  * See below for patterns.
  */
 $codex_conf['spellcheck'] = TRUE;

 /*
  * Spellcheck dictionary
  * List of spelling errors to fix, in extended regexp form.
  * The pattern is the array key, and the replacement is the
  * value.  So $spellcheck["foo"] = "bar" will replace all
  * occurrences of "foo" with "bar".
  */
 $spellcheck["([Dd])efinate"] = "\\1efinite";
 $spellcheck["([Dd])ependant"] = "\\1ependent"; // Not technically wrong, but still pisses me off
 $spellcheck["([Dd])iscribe"] = "\\1escribe";
 $spellcheck["([Dd])issapoint"] = "\\1isappoint";
 $spellcheck["([Dd])issapear"] = "\\1isappear";
 $spellcheck["Irregardless"] = "Regardless";
 $spellcheck["irregardless"] = "regardless";
 $spellcheck[",br>"] = "\n";

 /*
  * Search highlight color
  * When searching, the search string will be hilighted this color
  */
 $codex_conf['searchtext_color'] = "yellow";

 /*
  * Text focus color
  * Active text box will have a border with this color
  */
 $codex_conf['focus_color'] = "red";
?>
