<?php
$this->breadcrumbs=array(
	'Ordenes Pago Proveedores',
);

$this->menu=array(
	array('label'=>'Create OrdenesPagoProveedores', 'url'=>array('create')),
	array('label'=>'Manage OrdenesPagoProveedores', 'url'=>array('admin')),
);
?>

<h1>Ordenes Pago Proveedores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
