<?php
$this->breadcrumbs=array(
	'Sucursales'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Sucursales', 'url'=>array('admin')),
);
?>

<h1>Nueva Sucursal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>