{*
 *  category.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Category header template
 *
 *  Copyright (C) 2005 Christopher Han <xiphux@gmail.com>
 *}
<p>
 <strong>
  {if $unknown}
  Unknown
  {else}
  <a href="{$SCRIPT_FILE}?u={$catsort}&{$catidtype}={$catid}">{$catname}</a>
  {/if}
  </strong>
  {if $email}
    [<a href="mailto:{$email|strip_tags|strip:''}">{$email}</a>]
  {/if}
  {if $website}
    [<a href="{$website}">{$website}</a>]
  {/if}
</p>
