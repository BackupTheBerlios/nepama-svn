<h1>&rarr nepama: Administration - Artikelübersicht</h1>

<br/>
<table border="0" cellpadding="0" cellspacing="0" style="width: 75%; margin: auto;" class="formtable">
<tr class="trh">
 <td width="45%">Artikeltitel</td>
 <td width="25%">Verfasser</td>
 <td>Veröffentlichungsdatum</td>
 <td>Aktionen</td>
</tr>

 {section name=article loop=$articlelist}
<tr class="{cycle values="tr1,tr2"}">
 <td><a href="$$?m={$module_action}&amp;do=show&amp;id={$articlelist[article].id}">{$articlelist[article].title}</a></td>
 <td>{$articlelist[article].name}</td>
 <td>{$articlelist[article].date}</td>
 
  <td class="td_action">
   <a href="$$?m=admin&amp;mod={$module_action}&amp;do=articleedit&amp;id={$articlelist[article].id}"><img src="{$imagedir}admin_edit.png" alt="edit" /></a> 
   <a href="$$?m=admin&amp;mod={$module_action}&amp;do=articledel&amp;id={$articlelist[article].id}"><img src="{$imagedir}admin_del.png" alt="del" /></a>
 </td>
</tr>
 {sectionelse}
<tr>
 <td colspan="4">Keine Artikel vorhanden</td>
</tr>
 {/section}
</table>

<br/>
{pagelist perpage="$perpage" currentpage="$page" count="$count" link="$$?m=admin&amp;mod=$module_action&amp;do=list&amp;page=" sep=" "}