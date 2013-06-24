<?php
$this->breadcrumbs=array(
	'Detalle Colocaciones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DetalleColocaciones', 'url'=>array('index')),
	array('label'=>'Manage DetalleColocaciones', 'url'=>array('admin')),
);
?>

<h1>Create DetalleColocaciones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>