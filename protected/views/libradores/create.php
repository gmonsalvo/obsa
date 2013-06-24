<?php
$this->breadcrumbs=array(
	'Libradores'=>array('index'),
	'Nuevo',
);

$this->menu=array(
	array('label'=>'Listar Libradores', 'url'=>array('admin')),
);
?>

<h1>Nuevo Librador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>