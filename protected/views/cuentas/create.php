<?php
$this->breadcrumbs=array(
	'Cuentas'=>array('index'),
	'Nueva',
);

$this->menu=array(
	array('label'=>'Listar Cuentas', 'url'=>array('admin')),
);
?>

<h1>Nueva Cuenta</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>