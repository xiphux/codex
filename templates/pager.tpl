{*
 *  pager.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Fic list pager template
 *
 *  Copyright (C) 2009 Christopher Han <xiphux@gmail.com>
 *}
{if $pagerprev || $pagernext}
  <div class="pager">
    {if $pagerprev}
      <div class="pagerleft">
      <a href="{$SCRIPT_NAME}?u={$pagerdest}&pg={$pagerprev}{if $pagerauthorid}&aid={$pagerauthorid}{/if}{if $pagerseriesid}&sid={$pagerseriesid}{/if}{if $pagergenreid}&gid={$pagergenreid}{/if}{if $pagermatchupid}&mid={$pagermatchupid}{/if}">&lt; prev</a>
      </div>
    {/if}
    {if $pagernext}
      <div class="pagerright">
      <a href="{$SCRIPT_NAME}?u={$pagerdest}&pg={$pagernext}{if $pagerauthorid}&aid={$pagerauthorid}{/if}{if $pagerseriesid}&sid={$pagerseriesid}{/if}{if $pagergenreid}&gid={$pagergenreid}{/if}{if $pagermatchupid}&mid={$pagermatchupid}{/if}">next &gt;</a>
      </div>
    {/if}
  </div>
{/if}
