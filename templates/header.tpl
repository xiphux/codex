{*
 *  header.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Page header template
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
 *  $Id: header.tpl 368 2006-03-08 08:56:41Z xiphux $
 *}
{* $contentType = strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') === false ? 'text/html' : 'application/xhtml+xml';
header("Content-Type: $contentType; charset=utf-8"); *}
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>{$title}</title>
{literal}<style type="text/css">/*<![CDATA[[*/<!--
 body {color:{/literal}{$body_color}{literal}; background-color:{/literal}{$background_color}{literal}; position:relative; font-family:"Verdana",sans-serif;overflow:auto;}
 a:link {color:{/literal}{$link_color}{literal}; text-decoration:none;}
 a:active {color:{/literal}{$link_color}{literal}; text-decoration:none;}
 a:visited {color:{/literal}{$link_color}{literal}; text-decoration:none;}
 .italic {font-style:italic;}
 .bold {font-weight:bold;}
 .underline {text-decoration:underline;}
 .lemontext {color:{/literal}{$lemon_color}{literal};}
 .searchtext {color:{/literal}{$searchtext_color}{literal};font-weight:bold;}
 table {border:none; border-spacing:5px;}
 .main {width:100px;}
 form input.focus, form textarea.focus {border-color:{/literal}{$focus_color}{literal};color: #000;}
/*]]>*/--></style>{/literal}
{literal}
<script type="text/javascript">
//<!CDATA[
function highlightFormElements() {
    addFocusHandlers(document.getElementsByTagName("input"));
    addFocusHandlers(document.getElementsByTagName("textarea"));
}
function addFocusHandlers(elements) {
    for (i=0; i < elements.length; i++) {
        if (elements[i].type != "button" && elements[i].type != "submit" &&
            elements[i].type != "reset" && elements[i].type != "checkbox") {
            elements[i].onfocus=function() {this.className='focus';this.select()};
            elements[i].onclick=function() {this.select()};
            elements[i].onblur=function() {this.className=''};
        }
    }
}
window.onload = function() {highlightFormElements();}
//]]>
</script>
{/literal}
{$smarty.capture.header}
</head>
<body>
