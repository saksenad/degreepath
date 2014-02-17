<?php /* Smarty version Smarty-3.1.16, created on 2014-02-17 16:33:19
         compiled from "./templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1704122988530000362da137-70328185%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0360d049dff10f364dfc53ba2cc3958abf6ee6d' => 
    array (
      0 => './templates/index.tpl',
      1 => 1392672796,
      2 => 'file',
    ),
    '9e6b070c8cb75a2b091a59dcbc2131b5d5a97bf5' => 
    array (
      0 => './templates/layout.tpl',
      1 => 1392667604,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1704122988530000362da137-70328185',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_530000363162a6_70081478',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_530000363162a6_70081478')) {function content_530000363162a6_70081478($_smarty_tpl) {?><html>
  <head>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/degreepath.js"></script>
    <title>DegreePath</title>
  </head>
  <body>
    <h1>DegreePath</h1>
    <div class="content">
  <ul id="pending" class="connectedSortable">    
    <?php  $_smarty_tpl->tpl_vars['course'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['course']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['courses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['course']->key => $_smarty_tpl->tpl_vars['course']->value) {
$_smarty_tpl->tpl_vars['course']->_loop = true;
?>
      <li class="ui-state-default"><?php echo $_smarty_tpl->tpl_vars['course']->value['subject'];?>
 <?php echo $_smarty_tpl->tpl_vars['course']->value['course_number'];?>
</li>
    <?php } ?>
  </ul>
  <?php $_smarty_tpl->tpl_vars["num"] = new Smarty_variable("0", null, 0);?>
  <?php  $_smarty_tpl->tpl_vars['term'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['term']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['enrollments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['term']->key => $_smarty_tpl->tpl_vars['term']->value) {
$_smarty_tpl->tpl_vars['term']->_loop = true;
?>
    <ul id="sortable<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
" class="connectedSortable" data-term=<?php echo $_smarty_tpl->tpl_vars['terms']->value[$_smarty_tpl->tpl_vars['num']->value];?>
>
      <h3 align="center"><?php echo $_smarty_tpl->tpl_vars['terms']->value[$_smarty_tpl->tpl_vars['num']->value];?>
</h3>
      <?php  $_smarty_tpl->tpl_vars['enrollment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['enrollment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['term']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['enrollment']->key => $_smarty_tpl->tpl_vars['enrollment']->value) {
$_smarty_tpl->tpl_vars['enrollment']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['enrollment']->value) {?>
          <li class="ui-state-default" data-cid=<?php echo $_smarty_tpl->tpl_vars['enrollment']->value['id'];?>
><?php echo $_smarty_tpl->tpl_vars['enrollment']->value['subject'];?>
 <?php echo $_smarty_tpl->tpl_vars['enrollment']->value['course_number'];?>
 - <?php echo $_smarty_tpl->tpl_vars['enrollment']->value['name'];?>
</li>
        <?php }?>
      <?php } ?>
    </ul>
    <?php $_smarty_tpl->tpl_vars["num"] = new Smarty_variable($_smarty_tpl->tpl_vars['num']->value+1, null, 0);?>
  <?php } ?>
</div>
  </body>
</html>
<?php }} ?>
