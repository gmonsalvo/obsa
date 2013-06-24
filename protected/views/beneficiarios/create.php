<?php
$this->breadcrumbs=array(
	'Cliente'=>array('clientes/view/'.$_GET['clienteId']),
	'Nuevo Beneficiario',
);

$this->menu=array(
	array('label'=>'Ver Cliente', 'url'=>array('clientes/view/'.$_GET['clienteId'])),
);
?>

<h1>Nuevo Beneficiario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>