<?php
$this->breadcrumbs=array(
	'Orden Ingresos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Ordenes de Ingreso', 'url'=>array('admin')),
);
?>

<h1>Nuevo Depósito en Financiera</h1>

<?php echo $this->renderPartial('_formFinanciera', array('model'=>$model)); ?>