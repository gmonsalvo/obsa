<?php
$this->breadcrumbs=array(
	'Socios'=>array('index'),
	'Nuevo',
);

$this->menu=array(
	array('label'=>'Volver a la hoja del librador', 'url'=>array('/libradores/view','id'=>$_GET['libradorId'])),
);
?>

<h1>Nuevo Socio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>