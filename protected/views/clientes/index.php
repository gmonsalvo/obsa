<?php
$this->breadcrumbs=array(
	'Clientes',
);

$this->menu=array(
	array('label'=>'Nuevo Cliente', 'url'=>array('create')),
	array('label'=>'Administrar Clientes', 'url'=>array('admin')),
);
?>

<h1>Clientes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
