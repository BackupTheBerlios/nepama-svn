<h1>&rarr nepama: Administration - Einstellungen</h1>

<br/>
<form action="$$?m={$module_action}&amp;do=config&amp;moduleid={$moduleid}" method="POST">
<table border="0" cellpadding="0" cellspacing="0" style="width: 75%; margin: auto;" class="formtable">

{section name=c loop=$config}
<tr class="{cycle values="tr2,tr3"}">
 <td {if $config[c].type eq "TEXTAREA"}colspan="2"{/if} width="50%"><strong>{$config[c].name}</strong> - <span class="form_desc">{$config[c].desc}</span></td>
 
 {if $config[c].type eq "TEXT"}
  <td><input type="text" name="{$config[c].name}" value="{$config[c].value}" /></td>
 {elseif $config[c].type eq "TEXTAREA"}
  </tr>
  <tr>
   <td colspan="2"><textarea name="{$config[c].name}" rows="15">{$config[c].value}</textarea></td>
  </tr>
  <tr>
 {elseif $config[c].type eq "SELECT"}
  <td><select name="{$config[c].name}">{html_options options=$config[c].options selected=$config[c].selected}</select></td>
 {elseif $config[c].type eq "MSELECT"}
  <td><select name="{$config[c].name}" multiple="multiple" size="5">{html_options options=$config[c].options selected=$config[c].selected}</select></td>
 {/if}
</tr>
{sectionelse}
<tr class="trh">
 <td colspan="2">Keine Einstellungen vorhanden</td>
</tr>
{/section}

<tr class="tr1">
 <td><strong>Einstellungen speichern</strong></td>
 <td><input type="submit" name="submit" value="Speichern" />
</tr>

</table>
</form>