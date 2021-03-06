{*
 *  root.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Root page template
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *}
{$title}
<p><span class="label">Sort by:</span><br />
<a href="{$SCRIPT_NAME}?u=title">Title</a><br />
<a href="{$SCRIPT_NAME}?u=author">Author</a><br />
<a href="{$SCRIPT_NAME}?u=series">Series</a><br />
<a href="{$SCRIPT_NAME}?u=genre">Genre</a><br />
<a href="{$SCRIPT_NAME}?u=matchup">Matchup</a><br />
</p>
<form action="{$SCRIPT_NAME}?u=search" method="post">
<label for="search"><span class="label">Search for:</span></label>
<input type="text" name="search" />
<input type="submit" name="submit" value="Search" />
</form>
<form action="{$SCRIPT_NAME}?u=changetheme" method="post">
  <label for="theme"><span class="label">Set theme:</span></label>
  <select name="theme">
{foreach from=$themes item=theme}
  <option value="{$theme}" {if $theme == $selectedtheme}selected{/if}>{$theme}</option>
{/foreach}
  </select>
  <input type="submit" name="submit" value="Change" />
</form>
<p><span class="label">Utilities:</span><br />
{if $stats}
  <a href="{$SCRIPT_NAME}?u=stats">stats</a><br />
{/if}
{if $cache}
<a href="{$SCRIPT_NAME}?u=cacheflush">cacheflush</a>
{/if}
</p>
