<?php
$this->breadcrumbs=array(
	'Clientes'=>array('admin'),
	'Modificar'

,
);

$this->menu=array(
	array('label'=>'Listar Clientes', 'url'=>array('admin')),
	array('label'=>'Nuevo Cliente', 'url'=>array('create'))

,
);
?>

<h1>Modificar Cliente <?php echo $model->razonSocial; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>