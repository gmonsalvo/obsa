<?php
$this->breadcrumbs=array(
	'Ordenes Pagos'=>array('/ordenesPago/admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar OrdenesPago', 'url'=>array('/ordenesPago/admin')),
);
?>

<h1>Crear Orden de Pago</h1>
<?php //echo $valor;?> 
<?php echo $this->renderPartial('/ordenesPago/_form', array('model'=>$model, 'formaPagoOrden' => $formaPagoOrden, 'cheques' => $cheques, 'operacionCheque'=>  OperacionesCheques::model()->findByPk($operacionChequeId))); ?>