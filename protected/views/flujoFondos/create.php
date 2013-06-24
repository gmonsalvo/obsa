<?php
$this->breadcrumbs=array(
	'Flujo de Fondos'=>array('index'),
	'Nuevo',
);

$this->menu=array(
	array('label'=>'Listar Flujo de Fondos', 'url'=>array('admin')),
);
?>

<h1>Nuevo Flujo de Fondos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>