<?php
$this->breadcrumbs=array(
	'Recibos Detalles',
);

$this->menu=array(
	array('label'=>'Create RecibosDetalle', 'url'=>array('create')),
	array('label'=>'Manage RecibosDetalle', 'url'=>array('admin')),
);
?>

<h1>Recibos Detalles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
