<?php /* Smarty version 2.6.11, created on 2006-02-18 14:51:02
         compiled from default/modules/user/user_login.tpl */ ?>
<h1>&rarr; Benutzerkontrollzentrum: Bitte einloggen</h1>

<br/>
<form action="$$?m=<?php echo $this->_tpl_vars['module_action']; ?>
&amp;do=login" method="post">

<table border="0" cellpadding="0" cellspacing="0" style="width: 45%; margin: auto;">
 <tr><td><strong>Username</strong></td><td><input type="text" name="name" value="" /></td></tr>
 <tr><td><strong>Passwort</strong></td><td><input type="password" name="pass" value="" /></td></tr>
 <tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Einloggen!" /></td></tr>
 <tr></tr>
</table>

</form>