<?php
$this->breadcrumbs=array(
	'Ctacte Clientes',
);

$this->menu=array(
	array('label'=>'Listar Movimientos', 'url'=>array('admin')),
	array('label'=>'Nuevo Movimiento', 'url'=>array('create')),
);
?>

<h1>Detalle del Movimiento</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
