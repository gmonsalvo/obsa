<?php
$this->breadcrumbs=array(
	'Conceptos Pesificaciones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConceptosPesificaciones', 'url'=>array('index')),
	array('label'=>'Create ConceptosPesificaciones', 'url'=>array('create')),
	array('label'=>'View ConceptosPesificaciones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConceptosPesificaciones', 'url'=>array('admin')),
);
?>

<h1>Update ConceptosPesificaciones <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>