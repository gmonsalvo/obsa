<?php
$this->breadcrumbs=array(
	'Operadores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Operadores', 'url'=>array('admin')),
);
?>

<h1>Nuevo Operador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
