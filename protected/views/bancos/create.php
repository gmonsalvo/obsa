<?php
$this->breadcrumbs=array(
	'Bancos'=>array('index'),
	'Nuevo',
);

$this->menu=array(
	array('label'=>'Listar Bancos', 'url'=>array('admin')),
);
?>

<h1>Nuevo Banco</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>