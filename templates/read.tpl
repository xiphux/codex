{*
 *  read.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Fic reading template
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 *}
{if $fic}
{if $chapcount > 1}
{literal}
<script type="text/javascript">
//<!CDATA[
function nav1()
{
	var w = document.readnav1form.readnav1select.selectedIndex;
	var ch = document.readnav1form.readnav1select.options[w].value;
	window.location.href = {/literal}"{$SCRIPT_NAME}?u=read&fic={$fic.fic_id}&ch=" + ch;{literal}
}
function nav2()
{
	var w = document.readnav2form.readnav2select.selectedIndex;
	var ch = document.readnav2form.readnav2select.options[w].value;
	window.location.href = {/literal}"{$SCRIPT_NAME}?u=read&fic={$fic.fic_id}&ch=" + ch;{literal}
}
//]]>
</script>
{/literal}
{/if}
<div class="readnav">
{$fic.fic_title} by {foreach item=author name=authorfe from=$author}{if !$smarty.foreach.authorfe.first}, {/if}{$author.author_name}{foreachelse}Unknown{/foreach}
</div>
<div class="readnav">
{if $chapter > 1}
<span class="readnavleft">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.fic_id}&ch={$chapter-1}">prev</a>
</span>
{/if}
{if $chapcount > 1}
<form name="readnav1form" class="readnavcenter">
<select name="readnav1select" class="readnavcenter" name="chapter" onchange="nav1()">
{foreach from=$chapters item=chap}
  <option value="{$chap.num}" {if $chap.num == $chapter}selected{/if}>{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</option>
{/foreach}
</select>
</form>
{/if}
{if $chapter < $chapcount}
<span class="readnavright">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.fic_id}&ch={$chapter+1}">next</a>
</span>
{/if}
</div>
<hr />
{/if}

{$fdata}

{if ($chapter > 1) || ($chapter < $chapcount)}
<hr />
<div class="readnav">
{if $chapter > 1}
<span class="readnavleft">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.fic_id}&ch={$chapter-1}">prev</a>
</span>
{/if}
{if $chapcount > 1}
<form name="readnav2form" class="readnavcenter">
<select name="readnav2select" class="readnavcenter" name="chapter" onchange="nav2()">
{foreach from=$chapters item=chap}
  <option value="{$chap.num}" {if $chap.num == $chapter}selected{/if}>{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</option>
{/foreach}
</select>
</form>
{else}
<span class="readnavcenter">{if $chaptitle}{$chaptitle}{else}Chapter {$chapter}{/if}</span>
{/if}
{if $chapter < $chapcount}
<span class="readnavright">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.fic_id}&ch={$chapter+1}">next</a>
</span>
{/if}
</div>
{/if}
