<?php  
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

//n n   m     
?>

<h1>Nuevo Usuario</h1>

<?php echo $this->renderPartial('_formUsuario', array('model'=>$model, 'operador' => $operador, 'cliente' => $cliente)); ?>