<?php /* Smarty version 2.6.13, created on 2006-05-09 15:25:05
         compiled from index2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'popup_init', 'index2.tpl', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header2.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['content_title']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo smarty_function_popup_init(array('src' => "./overlib/overlib.js"), $this);?>

<div id="noscroll_content">
&nbsp;</div>
<div id="contentContainer">
	<div id="content">
	<h1><?php echo $this->_tpl_vars['content_title']; ?>
</h1>
	<?php echo $this->_tpl_vars['content_text']; ?>

	
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array('title' => 'foo')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>