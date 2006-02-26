<?php /* Smarty version 2.6.11, created on 2006-02-17 17:17:47
         compiled from default/modules/news/news_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'pagelist', 'default/modules/news/news_list.tpl', 17, false),)), $this); ?>
<h1>&rarr; Newsübersicht</h1>

<br/>

<?php unset($this->_sections['news']);
$this->_sections['news']['name'] = 'news';
$this->_sections['news']['loop'] = is_array($_loop=$this->_tpl_vars['newslist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['news']['show'] = true;
$this->_sections['news']['max'] = $this->_sections['news']['loop'];
$this->_sections['news']['step'] = 1;
$this->_sections['news']['start'] = $this->_sections['news']['step'] > 0 ? 0 : $this->_sections['news']['loop']-1;
if ($this->_sections['news']['show']) {
    $this->_sections['news']['total'] = $this->_sections['news']['loop'];
    if ($this->_sections['news']['total'] == 0)
        $this->_sections['news']['show'] = false;
} else
    $this->_sections['news']['total'] = 0;
if ($this->_sections['news']['show']):

            for ($this->_sections['news']['index'] = $this->_sections['news']['start'], $this->_sections['news']['iteration'] = 1;
                 $this->_sections['news']['iteration'] <= $this->_sections['news']['total'];
                 $this->_sections['news']['index'] += $this->_sections['news']['step'], $this->_sections['news']['iteration']++):
$this->_sections['news']['rownum'] = $this->_sections['news']['iteration'];
$this->_sections['news']['index_prev'] = $this->_sections['news']['index'] - $this->_sections['news']['step'];
$this->_sections['news']['index_next'] = $this->_sections['news']['index'] + $this->_sections['news']['step'];
$this->_sections['news']['first']      = ($this->_sections['news']['iteration'] == 1);
$this->_sections['news']['last']       = ($this->_sections['news']['iteration'] == $this->_sections['news']['total']);
?>
<div class="post">
<h2>&rarr; <a href="$$?m=<?php echo $this->_tpl_vars['module_action']; ?>
&amp;do=show&amp;id=<?php echo $this->_tpl_vars['newslist'][$this->_sections['news']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['newslist'][$this->_sections['news']['index']]['title']; ?>
</a></h2>
<p class="textj"><?php echo $this->_tpl_vars['newslist'][$this->_sections['news']['index']]['content']; ?>
</p>
<p class="small" style="text-align: right;">Verfasst von <?php echo $this->_tpl_vars['newslist'][$this->_sections['news']['index']]['name']; ?>
 am <?php echo $this->_tpl_vars['newslist'][$this->_sections['news']['index']]['date']; ?>
</p>
</div><br/>
 <?php endfor; else: ?>
<div class="post">
 <p class="textj">Keine Artikel vorhanden</p>
</div><br/>
 <?php endif; ?>

<?php echo smarty_function_pagelist(array('perpage' => ($this->_tpl_vars['perpage']),'currentpage' => ($this->_tpl_vars['page']),'count' => ($this->_tpl_vars['count']),'link' => "$$?m=".($this->_tpl_vars['module_action'])."&amp;page=",'sep' => ' '), $this);?>