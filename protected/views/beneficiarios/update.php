<?php
$this->breadcrumbs=array(
	'Cliente'=>array('clientes/view/'.$model->cliente->id),
	'Modificar Beneficiario',
);

$this->menu=array(
	array('label'=>'Ver Cliente', 'url'=>array('clientes/view/'.$model->cliente->id)),
);
?>

<h1>Modificar Beneficiario <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_updateForm', array('model'=>$model)); ?>