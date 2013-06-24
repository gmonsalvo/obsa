<?php
$this->breadcrumbs=array(
	'Clientes'=>array('index'),
	'Crear'
,
);

$this->menu=array(
	array('label'=>'Listar Clientes', 'url'=>array('admin'))
,
);
?>

<h1>Nuevo Cliente</h1>

<?php 

$this->renderPartial('_form', array('model'=>$model)); ?>