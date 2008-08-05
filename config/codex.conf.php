<?php
/*
 *  codex.conf.php
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: PHP viewer script configuration
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 */

/*
 * smarty_prefix
 * This is the prefix where smarty is installed.
 * (including trailing slash)
 * If an absolute (starts with /) path is given,
 * Smarty.class.php will be searched for in that directory.
 * If a relative (doesn't start with /) path is given,
 * that subdirectory inside the php include dirs will be
 * searched.  So, for example, if you specify the path as
 * "/usr/share/Smarty/" then the script will look for
 * /usr/share/Smarty/Smarty.class.php.
 * If you specify the path as "smarty/" then it will search
 * the include directories in php.ini's include_path directive,
 * so it would search in places like /usr/share/php and /usr/lib/php:
 * /usr/share/php/smarty/Smarty.class.php,
 * /usr/lib/php/smarty/Smarty.class.php, etc.
 * Leave blank to just search in the root of the php include directories
 * like /usr/share/php/Smarty.class.php, /usr/lib/php/Smarty.class.php, etc.
 */
$codex_conf['smarty_prefix'] = "smarty/";

/*
 * adodb_prefix
 * This is the prefix where adodb is installed.
 * Behaves the same way as smarty_prefix, but specifies
 * location of adodb_inc.php.
 */
$codex_conf['adodb_prefix'] = "adodb/";

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
 $codex_conf['persist'] = FALSE;

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
  * Adodb cache
  * Whether to use ADOdb caching
  * Note: caching is only recommended if your database server
  * is much slower than your web server, or your database server
  * is very overloaded.  Otherwise it could reduce performance.
  */
 $codex_conf['adodbcache'] = FALSE;

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
  * Can be an absolute path or relative path
  * Don't forget trailing slash
  */
 $codex_conf['basepath'] = "fics/";

 /*
  * This is the string that will be displayed at the top of the page
  * and in the page title.  The variable '$codex_appstring' will
  * expand to the name (codex) and version. '$codex_version' will
  * expand to the version only
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
  * If enabled, lemon fics will be shown.
  */
 $codex_conf['lemons'] = TRUE;

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
  * Debug
  * Whether to display debugging information
  */
 $codex_conf['debug'] = TRUE;
?>
