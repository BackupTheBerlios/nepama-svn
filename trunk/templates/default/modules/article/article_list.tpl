<h1>&rarr; Artikelübersicht</h1>

<br/>
<table border="0" cellpadding="0" cellspacing="0" style="width: 65%; margin: auto;" class="formtable">
<tr class="trh">
 <td width="45%">Artikeltitel</td>
 <td width="25%">Verfasser</td>
 <td>Veröffentlichungsdatum</td>
</tr>

 {section name=article loop=$articlelist}
<tr class="{cycle values="tr1,tr2"}">
 <td><a href="$$?m={$module_action}&amp;do=show&amp;id={$articlelist[article].id}">{$articlelist[article].title}</a></td>
 <td>{$articlelist[article].name}</td>
 <td>{$articlelist[article].date}</td>
</tr>
 {sectionelse}
<tr>
 <td colspan="3">Keine Artikel vorhanden</td>
</tr>
 {/section}
</table>

<br/>
{pagelist perpage="$perpage" currentpage="$page" count="$count" link="$$?m=$module_action&amp;page=" sep=" "}