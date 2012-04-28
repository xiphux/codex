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
	window.location.href = {/literal}"{$SCRIPT_NAME}?u=read&fic={$fic.id}&ch=" + ch;{literal}
}
function nav2()
{
	var w = document.readnav2form.readnav2select.selectedIndex;
	var ch = document.readnav2form.readnav2select.options[w].value;
	window.location.href = {/literal}"{$SCRIPT_NAME}?u=read&fic={$fic.id}&ch=" + ch;{literal}
}
//]]>
</script>
{/literal}
{/if}
{capture name=ficstr}
{$fic.title} <span class="label">by</span> {foreach item=author name=authorfe from=$author}{if !$smarty.foreach.authorfe.first}, {/if}{$author.name}{foreachelse}Unknown{/foreach}
{/capture}
<div class="readnav">
{if $chapter > 1}
<span class="readnavleft">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.id}&ch={$chapter-1}" accesskey="p">&lt; prev</a>
</span>
{/if}
{if $chapcount > 1}
<form name="readnav1form" class="readnavcenter">{$smarty.capture.ficstr} | 
<select name="readnav1select" class="readnavcenter" name="chapter" onchange="nav1()">
{foreach from=$chapters item=chap}
  <option value="{$chap.num}" {if $chap.num == $chapter}selected{/if}>{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</option>
{/foreach}
</select>
</form>
{elseif $chaptitle}
<span class="readnavcenter">{$smarty.capture.ficstr} | {$chaptitle}</span>
{/if}
{if $chapter < $chapcount}
<span class="readnavright">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.id}&ch={$chapter+1}" accesskey="n">next &gt;</a>
</span>
{/if}
</div>
{/if}

<div class="readtext">
{$fdata}
</div>
<div class="bottompadding">
</div>

{if ($chapter > 1) || ($chapter < $chapcount)}
<div class="bottomreadnav">
{if $chapter > 1}
<span class="bottomreadnavleft">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.id}&ch={$chapter-1}">&lt; prev</a>
</span>
{/if}
{if $chapcount > 1}
<form name="readnav2form" class="readnavcenter">{$smarty.capture.ficstr} | 
<select name="readnav2select" class="readnavcenter" name="chapter" onchange="nav2()">
{foreach from=$chapters item=chap}
  <option value="{$chap.num}" {if $chap.num == $chapter}selected{/if}>{if $chap.title}{$chap.title}{else}Chapter {$chap.num}{/if}</option>
{/foreach}
</select>
</form>
{else}
<span class="readnavcenter">
{$smarty.capture.ficstr} | 
{if $chaptitle}{$chaptitle}{else}Chapter {$chapter}{/if}</span>
{/if}
{if $chapter < $chapcount}
<span class="bottomreadnavright">
<a href="{$SCRIPT_NAME}?u=read&fic={$fic.id}&ch={$chapter+1}">next &gt;</a>
</span>
{/if}
</div>
{/if}
