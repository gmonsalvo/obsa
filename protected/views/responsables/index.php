<?php
$this->breadcrumbs=array(
	'Responsables',
);

$this->menu=array(
	array('label'=>'Nuevo Responsable', 'url'=>array('create')),
	array('label'=>'Administrar Responsables', 'url'=>array('admin')),
);
?>

<h1>Responsables</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
