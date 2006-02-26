<?php /* Smarty version 2.6.11, created on 2006-02-18 14:51:10
         compiled from default/modules/article/admin_article_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'default/modules/article/admin_article_list.tpl', 13, false),array('function', 'pagelist', 'default/modules/article/admin_article_list.tpl', 31, false),)), $this); ?>
<h1>&rarr nepama: Administration - Artikelübersicht</h1>

<br/>
<table border="0" cellpadding="0" cellspacing="0" style="width: 75%; margin: auto;" class="formtable">
<tr class="trh">
 <td width="45%">Artikeltitel</td>
 <td width="25%">Verfasser</td>
 <td>Veröffentlichungsdatum</td>
 <td>Aktionen</td>
</tr>

 <?php unset($this->_sections['article']);
$this->_sections['article']['name'] = 'article';
$this->_sections['article']['loop'] = is_array($_loop=$this->_tpl_vars['articlelist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['article']['show'] = true;
$this->_sections['article']['max'] = $this->_sections['article']['loop'];
$this->_sections['article']['step'] = 1;
$this->_sections['article']['start'] = $this->_sections['article']['step'] > 0 ? 0 : $this->_sections['article']['loop']-1;
if ($this->_sections['article']['show']) {
    $this->_sections['article']['total'] = $this->_sections['article']['loop'];
    if ($this->_sections['article']['total'] == 0)
        $this->_sections['article']['show'] = false;
} else
    $this->_sections['article']['total'] = 0;
if ($this->_sections['article']['show']):

            for ($this->_sections['article']['index'] = $this->_sections['article']['start'], $this->_sections['article']['iteration'] = 1;
                 $this->_sections['article']['iteration'] <= $this->_sections['article']['total'];
                 $this->_sections['article']['index'] += $this->_sections['article']['step'], $this->_sections['article']['iteration']++):
$this->_sections['article']['rownum'] = $this->_sections['article']['iteration'];
$this->_sections['article']['index_prev'] = $this->_sections['article']['index'] - $this->_sections['article']['step'];
$this->_sections['article']['index_next'] = $this->_sections['article']['index'] + $this->_sections['article']['step'];
$this->_sections['article']['first']      = ($this->_sections['article']['iteration'] == 1);
$this->_sections['article']['last']       = ($this->_sections['article']['iteration'] == $this->_sections['article']['total']);
?>
<tr class="<?php echo smarty_function_cycle(array('values' => "tr1,tr2"), $this);?>
">
 <td><a href="$$?m=<?php echo $this->_tpl_vars['module_action']; ?>
&amp;do=show&amp;id=<?php echo $this->_tpl_vars['articlelist'][$this->_sections['article']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['articlelist'][$this->_sections['article']['index']]['title']; ?>
</a></td>
 <td><?php echo $this->_tpl_vars['articlelist'][$this->_sections['article']['index']]['name']; ?>
</td>
 <td><?php echo $this->_tpl_vars['articlelist'][$this->_sections['article']['index']]['date']; ?>
</td>
 
  <td class="td_action">
   <a href="$$?m=admin&amp;mod=<?php echo $this->_tpl_vars['module_action']; ?>
&amp;do=articleedit&amp;id=<?php echo $this->_tpl_vars['articlelist'][$this->_sections['article']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['imagedir']; ?>
admin_edit.png" alt="edit" /></a> 
   <a href="$$?m=admin&amp;mod=<?php echo $this->_tpl_vars['module_action']; ?>
&amp;do=articledel&amp;id=<?php echo $this->_tpl_vars['articlelist'][$this->_sections['article']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['imagedir']; ?>
admin_del.png" alt="del" /></a>
 </td>
</tr>
 <?php endfor; else: ?>
<tr>
 <td colspan="4">Keine Artikel vorhanden</td>
</tr>
 <?php endif; ?>
</table>

<br/>
<?php echo smarty_function_pagelist(array('perpage' => ($this->_tpl_vars['perpage']),'currentpage' => ($this->_tpl_vars['page']),'count' => ($this->_tpl_vars['count']),'link' => "$$?m=admin&amp;mod=".($this->_tpl_vars['module_action'])."&amp;do=list&amp;page=",'sep' => ' '), $this);?>