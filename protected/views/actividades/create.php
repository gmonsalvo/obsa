<?php
$this->breadcrumbs=array(
	'Actividades'=>array('index'),
	'Nueva',
);

$this->menu=array(
		array('label'=>'Listar Actividades', 'url'=>array('admin')),
);
?>

<h1>Nueva Actividad</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>