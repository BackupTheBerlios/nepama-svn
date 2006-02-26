<h1>&rarr nepama: Administration - Module</h1>
<p class="small"><strong>Weitere Optionen</strong>: <span class="deac">Modul installieren</span> - <span class="deac">Verzeichnisse bereinigen</span>.</p>

<table  border="0" cellpadding="0" cellspacing="0" style="width: 65%; margin: auto;" class="formtable">
<tr class="trh">
 <td>Modul</td><td>Version</td><td>Autor</td><td>Aktiv?</td><td class="td_action">Aktionen</td>
</tr>

{section name=module loop=$module}
<tr class="{cycle values="tr1,tr2"}">
 <td>{$module[module].name}</td>
 <td>{$module[module].version}</td>
 <td>{$module[module].author}</td>
 <td>{if $module[module].active eq "1"}ja{else}nein{/if}</td>
 <td class="td_action">
 <a href="$$?m={$module_action}&amp;do=module&amp;moduleid={$module[module].id}"><img src="{$imagedir}admin_edit.png" alt="edit" /></a>&nbsp;
 <a href="$$?m={$module_action}&amp;do=module&amp;moduleid={$module[module].id}&del=1"><img src="{$imagedir}admin_del.png" alt="del" /></a> 
</tr>
{sectionelse}
 <tr class="trh"><td colspan="5">Keine Module vorhanden</td></tr>
{/section}

</table>