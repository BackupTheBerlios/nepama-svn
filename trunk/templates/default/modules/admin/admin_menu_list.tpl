<h1>&rarr nepama: Administration - Men�s</h1>
<p class="small"><strong>Weitere Optionen</strong>: <a href="$$?m={$module_action}&amp;do=menu&a=add">Men� hinzuf�gen</a> - <span class="deac">Men�s generieren</span>.</p>

<table  border="0" cellpadding="0" cellspacing="0" style="width: 65%; margin: auto;" class="formtable">
<tr class="trh">
 <td>Men�</td><td class="td_action">Aktionen</td>
</tr>

{section name=menu loop=$menulist}
<tr class="{cycle values="tr1,tr2"}">
 <td>{$menulist[menu].name}</td>
 <td class="td_action">
 <a href="$$?m={$module_action}&amp;do=menu&amp;menuid={$menulist[menu].id}&amp;a=edit"><img src="{$imagedir}admin_edit.png" alt="edit" /></a>&nbsp;
 <a href="$$?m={$module_action}&amp;do=menu&amp;menuid={$menulist[menu].id}&amp;a=del"><img src="{$imagedir}admin_del.png" alt="del" /></a> 
</tr>
{sectionelse}
 <tr class="trh"><td colspan="2">Keine Men�s vorhanden</td></tr>
{/section}

</table>