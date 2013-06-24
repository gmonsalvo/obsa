<?php
$this->breadcrumbs=array(
	'Comisiones Operadores',
);

$this->menu=array(
	array('label'=>'Create ComisionesOperadores', 'url'=>array('create')),
	array('label'=>'Manage ComisionesOperadores', 'url'=>array('admin')),
);
?>

<h1>Comisiones Operadores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
