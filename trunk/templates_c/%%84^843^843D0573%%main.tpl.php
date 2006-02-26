<?php /* Smarty version 2.6.11, created on 2006-02-17 17:24:45
         compiled from default/main.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/Strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" lang="de">
<head>
 <title><?php echo $this->_tpl_vars['page_title']; ?>
</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['templatedir']; ?>
style.css" />
 </head>
<body>

<div id="container">
  <div id="title">&nbsp;</div>
  
  <div id="bread">
  
  Du befindest dich hier: 
  <a href="$$">nepama. Homepage</a> | [<a href="$$?m=user&amp;do=li">i</a>] Hallo <?php echo $this->_tpl_vars['session_user']; ?>
! [<a href="$$?m=user&amp;do=lo">x</a>]
  
  </div>
  
 <div id="content">
 <?php echo $this->_tpl_vars['maincontent']; ?>

 </div>
 
 <ul id="menu">
 <?php unset($this->_sections['menupoint']);
$this->_sections['menupoint']['name'] = 'menupoint';
$this->_sections['menupoint']['loop'] = is_array($_loop=$this->_tpl_vars['menu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['menupoint']['show'] = true;
$this->_sections['menupoint']['max'] = $this->_sections['menupoint']['loop'];
$this->_sections['menupoint']['step'] = 1;
$this->_sections['menupoint']['start'] = $this->_sections['menupoint']['step'] > 0 ? 0 : $this->_sections['menupoint']['loop']-1;
if ($this->_sections['menupoint']['show']) {
    $this->_sections['menupoint']['total'] = $this->_sections['menupoint']['loop'];
    if ($this->_sections['menupoint']['total'] == 0)
        $this->_sections['menupoint']['show'] = false;
} else
    $this->_sections['menupoint']['total'] = 0;
if ($this->_sections['menupoint']['show']):

            for ($this->_sections['menupoint']['index'] = $this->_sections['menupoint']['start'], $this->_sections['menupoint']['iteration'] = 1;
                 $this->_sections['menupoint']['iteration'] <= $this->_sections['menupoint']['total'];
                 $this->_sections['menupoint']['index'] += $this->_sections['menupoint']['step'], $this->_sections['menupoint']['iteration']++):
$this->_sections['menupoint']['rownum'] = $this->_sections['menupoint']['iteration'];
$this->_sections['menupoint']['index_prev'] = $this->_sections['menupoint']['index'] - $this->_sections['menupoint']['step'];
$this->_sections['menupoint']['index_next'] = $this->_sections['menupoint']['index'] + $this->_sections['menupoint']['step'];
$this->_sections['menupoint']['first']      = ($this->_sections['menupoint']['iteration'] == 1);
$this->_sections['menupoint']['last']       = ($this->_sections['menupoint']['iteration'] == $this->_sections['menupoint']['total']);
?>
   <li><?php if ($this->_tpl_vars['menu'][$this->_sections['menupoint']['index']]['islink'] == 'true'): ?><a href="<?php echo $this->_tpl_vars['menu'][$this->_sections['menupoint']['index']]['link']; ?>
"><?php echo $this->_tpl_vars['menu'][$this->_sections['menupoint']['index']]['title']; ?>
</a><?php else:  echo $this->_tpl_vars['menu'][$this->_sections['menupoint']['index']]['title'];  endif; ?></li>
 <?php endfor; else: ?>
   <li>Keine Einträge vorhanden</li>
 <?php endif; ?>
</ul> 
  
</div>

<br/>
<div class="small" style="text-align: center;">powered by nepama-<?php echo $this->_tpl_vars['nepa_version']; ?>
 &#8222;<?php echo $this->_tpl_vars['nepa_codename']; ?>
&#8220; -- #DEBUGDATA#</div>

</body>
</html>