<h1>&rarr nepama: Administration - Artikel</h1>

<br/>

<form action="$$?m=admin&amp;mod={$module_action}&amp;do={$do}" method="post" class="adminform">
<table border="0" cellpadding="0" cellspacing="0" style="width: 75%; margin: auto;" class="formtable">

<tr class="tr1">
 <td width="50%"><strong>Titel</strong><span class="form_desc">Überschrift.</span></td>
 <td><input type="text" name="title" value="{$title}" /></td>
</tr>

<tr class="tr2">
 <td colspan="2"><strong>Inhalt</strong><span class="form_desc">Inhalt des Artikels.</span></td>
</tr>

<tr class="tr2">
 <td colspan="2"><textarea rows="15" name="content" style="font-family: Courier New;">{$content}</textarea></td>
</tr>

<tr class="tr1">
 <td><strong>Speichern</strong><span class="form_desc">Einstellungen speichern.</span></td>
 <td><input type="submit" name="submit" value="Speichern" /></td>
</tr>
</table>
</form>