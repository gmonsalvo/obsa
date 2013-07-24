<?php
$this->breadcrumbs=array(
	'Financieras'=>array('index'),
	'Nueva',
);

$this->menu=array(
	array('label'=>'Listar Financieras', 'url'=>array('index')),
	array('label'=>'Administrar Financieras', 'url'=>array('admin')),
);
?>

<h1>Nueva Financiera</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>