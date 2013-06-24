<?php
$this->breadcrumbs=array(
	'Detalle Pesificaciones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DetallePesificaciones', 'url'=>array('index')),
	array('label'=>'Manage DetallePesificaciones', 'url'=>array('admin')),
);
?>

<h1>Create DetallePesificaciones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>