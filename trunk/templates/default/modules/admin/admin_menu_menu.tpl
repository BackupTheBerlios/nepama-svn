<h1>&rarr nepama: Administration - Menüs</h1>

<br/>
<form action="$$?m={$module_action}&amp;do=menu&amp;menuid={$id}&amp;a=edit" method="POST">
<table border="0" cellpadding="0" cellspacing="0" style="width: 75%; margin: auto;" class="formtable">
<tr class="tr1">
 <td style="width: 50%;"><strong>Name</strong> - <span class="form_desc">Name des Menüs</span></td>
 <td><input type="text" name="name" value="{$name}" /></td>
</tr>
<tr class="tr2">
<tr>
 <td><strong>Reihenfolge</strong> - <span class="form_desc">Verschiebe die Elemente um die Reihenfolge zu verändern</span></td>
 <td><select name="menupoints[]" multiple="multiple">{foreach from=$pointlist item=item}<option value="{$item.id}">{$item.title}</option>{/foreach}</select> 
 <input type="button" value="up" onclick="Selectbox.moveOptionUp(this.form.menupoints[])"><br/>
 <input type="button" value="down" onclick="Selectbox.moveOptionDown(this.form.menupoints)"></td>
</tr>
<tr>
 <td><strong>Speichern</strong></td>
 <td><input type="submit" name="submit" value="Speichern" /></td>
</tr>
</table>
