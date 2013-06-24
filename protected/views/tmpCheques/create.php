<?php
if(isset($_GET['operadorId']) && isset($_GET['clienteId']) && isset($_GET['fecha'])){
	$operadorId=$_GET['operadorId'];
	$clienteId=$_GET['clienteId'];
	$fecha=$_GET['fecha'];
}
else{
	$operadorId='';
	$clienteId='';
	$fecha=Date('d/m/Y');
}
?>
<?php
$this->breadcrumbs=array(
	'Operacion'=>array('operacionesCheques/nuevaOperacion?operadorId='.$operadorId.'&clienteId='.$clienteId.'&fecha='.$fecha),
	'Nuevo Cheque',
);


?>

<h1>Nuevo Cheque</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>