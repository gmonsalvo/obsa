<?php
$this->breadcrumbs=array(
	'Conceptos Pesificaciones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConceptosPesificaciones', 'url'=>array('index')),
	array('label'=>'Manage ConceptosPesificaciones', 'url'=>array('admin')),
);
?>

<h1>Create ConceptosPesificaciones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>