<?php
$this->breadcrumbs=array(
	'Provinciases',
);

$this->menu=array(
	array('label'=>'Nueva Provincia', 'url'=>array('create')),
	array('label'=>'listar Provincias', 'url'=>array('admin')),
);
?>

<h1>Provincias</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
