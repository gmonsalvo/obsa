<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Usuarios', 'url'=>array('admin')),
	);
?>

<h1>Nuevo Usuario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>