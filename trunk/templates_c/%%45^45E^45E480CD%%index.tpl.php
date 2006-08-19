<?php /* Smarty version 2.6.13, created on 2006-05-10 19:04:01
         compiled from index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['content_title']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="background_content">
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