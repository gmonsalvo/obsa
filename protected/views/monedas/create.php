<?php
$this->breadcrumbs=array(
	'Monedases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Monedas', 'url'=>array('admin')),

);
?>

<h1>Nueva Moneda</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>