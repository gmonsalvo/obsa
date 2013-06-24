<?php
$this->breadcrumbs=array(
	'Forma Pago Ordens',
);

$this->menu=array(
	array('label'=>'Create FormaPagoOrden', 'url'=>array('create')),
	array('label'=>'Manage FormaPagoOrden', 'url'=>array('admin')),
);
?>

<h1>Forma Pago Ordens</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
