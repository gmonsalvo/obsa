<?php
$this->breadcrumbs=array(
	'Responsables'=>array('index'),
	'Nuevo',
);

$this->menu=array(
	array('label'=>'Listar Responsables', 'url'=>array('index')),
	array('label'=>'Administrar Responsables', 'url'=>array('admin')),
);
?>

<h1>Nuevo Responsable</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>