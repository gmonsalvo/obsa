<?php
$this->breadcrumbs=array(
	'Orden Ingresos',
);

$this->menu=array(
	array('label'=>'Create OrdenIngreso', 'url'=>array('create')),
	array('label'=>'Manage OrdenIngreso', 'url'=>array('admin')),
);
?>

<h1>Orden Ingresos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
