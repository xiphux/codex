{*
 *  header.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Page header template
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *}
{* $contentType = strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') === false ? 'text/html' : 'application/xhtml+xml';
header("Content-Type: $contentType; charset=utf-8"); *}
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta name = "viewport" content = "width = device-width">
<title>{$title}</title>
{literal}
<link rel="stylesheet" href="css/codex.css" type="text/css" />
<link rel="stylesheet" href="css/themes/{/literal}{$theme}{literal}" type="text/css" />
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
