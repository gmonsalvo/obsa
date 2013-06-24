<?php
$this->breadcrumbs=array(
	'Socios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Volver a la hoja del librador', 'url'=>array('/libradores/view','id'=>$model->libradorId)),
);
?>

<h1>Modificar Socio Nro: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>