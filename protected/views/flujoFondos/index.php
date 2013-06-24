<?php
$this->breadcrumbs=array(
	'Flujo de Fondos',
);

$this->menu=array(
    	array('label'=>'Listar Flujo de Fondos', 'url'=>array('admin')),
		array('label'=>'Nuevo Flujo de Fondos', 'url'=>array('create')),

);
?>

<h1>Flujo de Fondos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
