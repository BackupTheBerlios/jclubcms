<?php /* Smarty version 2.6.13, created on 2006-05-09 21:09:36
         compiled from header2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'header2.tpl', 7, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.1"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC XHTML "-//W3C//DTD XHTML 1.1//DE">
<html>
<head>
<title><?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</title>
<link rel="stylesheet" href="./templates/style/style.css" type="text/css"/></head>
<body>
<div id="header">&nbsp;</div>
<div id="navigationContainer">
	<div id="navigation">
		<?php unset($this->_sections['topnav']);
$this->_sections['topnav']['name'] = 'topnav';
$this->_sections['topnav']['loop'] = is_array($_loop=$this->_tpl_vars['nav']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['topnav']['show'] = true;
$this->_sections['topnav']['max'] = $this->_sections['topnav']['loop'];
$this->_sections['topnav']['step'] = 1;
$this->_sections['topnav']['start'] = $this->_sections['topnav']['step'] > 0 ? 0 : $this->_sections['topnav']['loop']-1;
if ($this->_sections['topnav']['show']) {
    $this->_sections['topnav']['total'] = $this->_sections['topnav']['loop'];
    if ($this->_sections['topnav']['total'] == 0)
        $this->_sections['topnav']['show'] = false;
} else
    $this->_sections['topnav']['total'] = 0;
if ($this->_sections['topnav']['show']):

            for ($this->_sections['topnav']['index'] = $this->_sections['topnav']['start'], $this->_sections['topnav']['iteration'] = 1;
                 $this->_sections['topnav']['iteration'] <= $this->_sections['topnav']['total'];
                 $this->_sections['topnav']['index'] += $this->_sections['topnav']['step'], $this->_sections['topnav']['iteration']++):
$this->_sections['topnav']['rownum'] = $this->_sections['topnav']['iteration'];
$this->_sections['topnav']['index_prev'] = $this->_sections['topnav']['index'] - $this->_sections['topnav']['step'];
$this->_sections['topnav']['index_next'] = $this->_sections['topnav']['index'] + $this->_sections['topnav']['step'];
$this->_sections['topnav']['first']      = ($this->_sections['topnav']['iteration'] == 1);
$this->_sections['topnav']['last']       = ($this->_sections['topnav']['iteration'] == $this->_sections['topnav']['total']);
?>
	<a href="./index2.php?nav_id=<?php echo $this->_tpl_vars['nav'][$this->_sections['topnav']['index']]['menu_ID']; ?>
"><?php echo $this->_tpl_vars['nav'][$this->_sections['topnav']['index']]['menu_name']; ?>
</a>
	<?php endfor; endif; ?>
	</div>
</div>
<div id="subnavContainer">
	<div id="subnav">
		<?php unset($this->_sections['subnav']);
$this->_sections['subnav']['name'] = 'subnav';
$this->_sections['subnav']['loop'] = is_array($_loop=$this->_tpl_vars['subnav']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['subnav']['show'] = true;
$this->_sections['subnav']['max'] = $this->_sections['subnav']['loop'];
$this->_sections['subnav']['step'] = 1;
$this->_sections['subnav']['start'] = $this->_sections['subnav']['step'] > 0 ? 0 : $this->_sections['subnav']['loop']-1;
if ($this->_sections['subnav']['show']) {
    $this->_sections['subnav']['total'] = $this->_sections['subnav']['loop'];
    if ($this->_sections['subnav']['total'] == 0)
        $this->_sections['subnav']['show'] = false;
} else
    $this->_sections['subnav']['total'] = 0;
if ($this->_sections['subnav']['show']):

            for ($this->_sections['subnav']['index'] = $this->_sections['subnav']['start'], $this->_sections['subnav']['iteration'] = 1;
                 $this->_sections['subnav']['iteration'] <= $this->_sections['subnav']['total'];
                 $this->_sections['subnav']['index'] += $this->_sections['subnav']['step'], $this->_sections['subnav']['iteration']++):
$this->_sections['subnav']['rownum'] = $this->_sections['subnav']['iteration'];
$this->_sections['subnav']['index_prev'] = $this->_sections['subnav']['index'] - $this->_sections['subnav']['step'];
$this->_sections['subnav']['index_next'] = $this->_sections['subnav']['index'] + $this->_sections['subnav']['step'];
$this->_sections['subnav']['first']      = ($this->_sections['subnav']['iteration'] == 1);
$this->_sections['subnav']['last']       = ($this->_sections['subnav']['iteration'] == $this->_sections['subnav']['total']);
?>
	<a href="./index2.php?nav_id=<?php echo $this->_tpl_vars['subnav'][$this->_sections['subnav']['index']]['menu_ID']; ?>
"><?php echo $this->_tpl_vars['subnav'][$this->_sections['subnav']['index']]['menu_name']; ?>
</a>
	<?php endfor; endif; ?>
	</div>
</div>