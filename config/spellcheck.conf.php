<?php
/*
 * spellcheck.conf.php
 * Codex: A PHP/MySQL fanfiction database
 * Component: Spellcheck auto-correction patterns
 *
 * Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 */


/*
 * Spellcheck dictionary
 * List of spelling errors to fix, in perl regexp form.
 * The pattern is the array key, and the replacement is the
 * value.  So $spellcheck["/foo/"] = "bar" will replace all
 * occurrences of "foo" with "bar".
 *
 * For the more technical:
 * These are just parameters into PHP's preg_replace, with
 * the array key as the pattern and the array value as the
 * replacement, so you can actually do any transformations
 * that you want with this, not just spelling corrections.
 */
$spellcheck["/([Dd])efinate/"] = "$1efinite";
$spellcheck["/([Dd])ependant/"] = "$1ependent"; // Not technically wrong, but still pisses me off
$spellcheck["/([Dd])iscribe/"] = "$1escribe";
$spellcheck["/([Dd])issapoint/"] = "$1isappoint";
$spellcheck["/([Dd])issapear/"] = "$1isappear";
$spellcheck["/Irregardless/"] = "Regardless";
$spellcheck["/irregardless/"] = "regardless";
$spellcheck["/([Tt])hw /"] = "$1he ";
$spellcheck["/([Dd])angurus/"] = "$1angerous";
$spellcheck["/([Cc])lumsyly/"] = "$1lumsily";
$spellcheck["/([Ss])parr([^\w])/"] = "$1par$2";
$spellcheck["/([Uu])nsion/"] = "$1nison";
$spellcheck["/([Bb])uisness/"] = "$1usiness";
$spellcheck["/([Bb])eemed/"] = "$1eamed";
$spellcheck["/([Pp])eice/"] = "$1iece";
$spellcheck["/([Ee])ach([Oo])ther/"] = "$1ach $2ther";
$spellcheck["/([Pp])riveliege/"] = "$1rivilege";
$spellcheck["/([Dd])iscribing/"] = "$1escribing";
$spellcheck["/([Ee])xcersize/"] = "$1xercise";
$spellcheck["/([Pp])revert/"] = "$1ervert";
$spellcheck["/([Aa])ntoher/"] = "$1nother";
$spellcheck["/([Ss])torey/"] = "$1tory";
$spellcheck["/Irratic/"] = "Erratic";
$spellcheck["/irratic/"] = "erratic";
$spellcheck["/([Pp])rocent/"] = "$1ercent";
$spellcheck["/([Rr])ediculous/"] = "$1idiculous";
$spellcheck["/([Ll])enght/"] = "$1ength";
$spellcheck["/([Tt])estemony/"] = "$1estimony";
$spellcheck["/Incountered/"] = "Encountered";
$spellcheck["/incountered/"] = "encountered";
$spellcheck["/([Uu])ncomiting/"] = "$1ncomitting";
$spellcheck["/([Ii])ngrediences/"] = "$1ngredients";
$spellcheck["/([Cc])urcuit/"] = "$1ircuit";
$spellcheck["/([Pp])roffread/"] = "$1roofread";
$spellcheck["/([Rr])emainded/"] = "$1emained";
$spellcheck["/ ti /"] = " it ";
$spellcheck["/ Ti /"] = " It ";
$spellcheck["/([Bb])reakfest/"] = "$1reakfast";
$spellcheck["/([Gg])aurded/"] = "$1uarded";
$spellcheck["/([Mm])artail/"] = "$1artial";
$spellcheck["/([Aa])amazinfg/"] = "$1mazing";
$spellcheck["/([Dd])ecion/"] = "$1ecision";

/* Some series-specific stuff */
$spellcheck["/NAbiki/"] = "Nabiki";
$spellcheck["/([Nn])ermia/"] = "$1erima";
$spellcheck["/([Nn])ermai/"] = "$1erima";
$spellcheck["/([Ss])nesei/"] = "$1ensei";

/* HTML typos */
$spellcheck["/,br>/"] = "\n";
$spellcheck["/&lt;?/"] = "<";
$spellcheck["/&gt;?/"] = ">";

?>
