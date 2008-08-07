{*
 *  read.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Fic reading template
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *}
{if $fic}
{literal}
<script type="text/javascript">
//<!CDATA[
function nav1()
{
	var w = document.readnav1form.readnav1select.selectedIndex;
	var ch = document.readnav1form.readnav1select.options[w].value;
	window.location.href = {/literal}"{$SCRIPT_NAME}?u=read&fic={$ficid}&ch=" + ch;{literal}
}
function nav2()
{
	var w = document.readnav2form.readnav2select.selectedIndex;
	var ch = document.readnav2form.readnav2select.options[w].value;
	window.location.href = {/literal}"{$SCRIPT_NAME}?u=read&fic={$ficid}&ch=" + ch;{literal}
}
//]]>
</script>
{/literal}
<div class="readnav">
{$fic.fic_title} by {foreach item=author name=authorfe from=$author}{if !$smarty.foreach.authorfe.first}, {/if}{$author.author_name}{foreachelse}Unknown{/foreach}
</div>
<div class="readnav">
{if $prev}
<span class="readnavleft">
<a href="{$SCRIPT_NAME}?u=read&fic={$ficid}&ch={$prev}">prev</a>
</span>
{/if}
<form name="readnav1form" class="readnavcenter">
<select name="readnav1select" class="readnavcenter" name="chapter" onchange="nav1()">
{foreach from=$chapters item=chap}
  <option value="{$chap.num}" {if $chap.num == $chapter}selected{/if}>{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</option>
{/foreach}
</select>
</form>
{if $next}
<span class="readnavright">
<a href="{$SCRIPT_NAME}?u=read&fic={$ficid}&ch={$next}">next</a>
</span>
{/if}
</div>
<hr />
{/if}

{$fdata}

{if $prev || $next}
<hr />
<div class="readnav">
{if $prev}
<span class="readnavleft">
<a href="{$SCRIPT_NAME}?u=read&fic={$ficid}&ch={$prev}">prev</a>
</span>
{/if}
<form name="readnav2form" class="readnavcenter">
<select name="readnav2select" class="readnavcenter" name="chapter" onchange="nav2()">
{foreach from=$chapters item=chap}
  <option value="{$chap.num}" {if $chap.num == $chapter}selected{/if}>{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</option>
{/foreach}
</select>
</form>
{if $next}
<span class="readnavright">
<a href="{$SCRIPT_NAME}?u=read&fic={$ficid}&ch={$next}">next</a>
</span>
{/if}
</div>
{/if}
