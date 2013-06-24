<?php
$this->breadcrumbs=array(
	'Localidades'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Localidades', 'url'=>array('admin')),
	
);
?>

<h1>Nueva Localidad</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>