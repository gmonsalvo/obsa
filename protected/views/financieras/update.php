<?php
$this->breadcrumbs=array(
	'Financieras'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Financieras', 'url'=>array('index')),
	array('label'=>'Nueva Financiera', 'url'=>array('create')),
	array('label'=>'Ver Financiera', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Financieras', 'url'=>array('admin')),
);
?>

<h1>Actualizar Financiera <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>