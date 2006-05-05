{*
 *  stats.tpl
 *  Codex: A PHP/MySQL fanfiction database
 *  Component: Stats page system info template
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
 *  $Id: stats.tpl 372 2006-03-08 21:31:46Z xiphux $
 *}
<p><strong><span class="underline">{$appstring}</span></strong>:
<br />Copyright (c) {$cdate} <a href="mailto:{$cauthor_email}">{$cauthor}</a>
<br />Distributed under the terms of the <a href="http://www.gnu.org/licenses/gpl.html">GNU General Public License</a>, v2 or later
</p>
<p><strong><span class="underline">System statistics:</span></strong>
<br /><strong>Server: </strong>{$server}
<br /><strong>Uname: </strong>{$uname}
<br /><strong>Uptime (days): </strong>{$uptime_days}
<br /><strong>Uptime (%): </strong>{$uptime_percent}
<br /><strong>Load average: </strong>{$loadavg}
</p>
<p><strong><span class="underline">Data statistics:</span></strong>
<br /><strong>Fics: </strong>{$fics}
<br /><strong>Authors: </strong>{$authors}
<br /><strong>Genres: </strong>{$genres}
<br /><strong>Series: </strong>{$series}
<br /><strong>Characters: </strong>{$characters}
<br /><strong>Matchups: </strong>{$matchups}
</p>
<p><strong><span class="underline">Database statistics:</span></strong></p>
