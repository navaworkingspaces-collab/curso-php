<?php
/* Smarty version 5.6.0, created on 2025-10-31 21:08:10
  from 'file:modulo13_user.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.6.0',
  'unifunc' => 'content_6905172a02a6d0_68351894',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8a82f432e0a83400d88a8975e3acd2e4c290214d' => 
    array (
      0 => 'modulo13_user.tpl',
      1 => 1761941289,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6905172a02a6d0_68351894 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\curso-php\\templates';
$_smarty_tpl->assign('saludo', "Hola", false, NULL);?>
<h1><?php echo $_smarty_tpl->getValue('saludo');?>
 <?php echo $_smarty_tpl->getValue('nombre');?>
</h1>

<?php if ($_smarty_tpl->getValue('edad') >= 18) {?>
    <p class="text-success">Mayor de edad</p>
<?php } else { ?>
    <p class="text-warning">Menor de edad</p>
<?php }?>

<h3>Usuarios:</h3>
<ul>
<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('usuarios'), 'u');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('u')->value) {
$foreach0DoElse = false;
?>
    <li><strong><?php echo $_smarty_tpl->getValue('u')['nombre'];?>
</strong> - <?php echo $_smarty_tpl->getValue('u')['edad'];?>
 años</li>
<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
</ul><?php }
}
