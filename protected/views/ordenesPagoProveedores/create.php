<?php
$this->breadcrumbs=array(
	'Crear',
);

?>

<h1>Crear Orden de Pago a Proveedor</h1>
<?php echo $this->renderPartial('/ordenesPagoProveedores/_form', array('model'=>$model, 'cheques' => $cheques)); ?>