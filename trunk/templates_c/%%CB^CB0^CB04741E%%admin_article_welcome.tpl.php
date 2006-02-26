<?php /* Smarty version 2.6.11, created on 2006-02-18 14:51:08
         compiled from default/modules/article/admin_article_welcome.tpl */ ?>
<h1>&rarr nepama: Administration - Artikel</h1>

<p class="textj">Willkommen im Administrationszentrum von nepama. Hier ist noch ausreichend Platz um später unglaublich wichtige Informationen, wie zum Beispiel Benutzerstatistiken unterzubringen.</p>

<h2>&#187; Optionen:</h2>
<ul>
	<li><a href="$$?m=admin&amp;moduleid=<?php echo $this->_tpl_vars['module_id']; ?>
&amp;do=config">Einstellungen bearbeiten</a></li>
	<li><a href="$$?m=admin&amp;mod=<?php echo $this->_tpl_vars['module_action']; ?>
&amp;do=list">Artikel auflisten (bearbeiten, löschen)</a></li>
	<li><a href="$$?m=admin&amp;mod=<?php echo $this->_tpl_vars['module_action']; ?>
&amp;do=articleadd">Artikel erstellen</a></li>
</ul>