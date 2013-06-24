<?php
$this->breadcrumbs=array(
	'Conceptos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Conceptos', 'url'=>array('admin')),
	array('label'=>'Nuevo Concepto', 'url'=>array('create')),
);
?>

<h1>Modificar Concepto Nro: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>