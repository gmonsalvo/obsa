<?php
$this->breadcrumbs=array(
	'Ordenes Pago Proveedores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrdenesPagoProveedores', 'url'=>array('index')),
	array('label'=>'Create OrdenesPagoProveedores', 'url'=>array('create')),
	array('label'=>'View OrdenesPagoProveedores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrdenesPagoProveedores', 'url'=>array('admin')),
);
?>

<h1>Update OrdenesPagoProveedores <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>