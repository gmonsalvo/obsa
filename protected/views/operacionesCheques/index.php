<?php
$this->breadcrumbs=array(
	'Operaciones Cheques',
);

$this->menu=array(
	array('label'=>'Create OperacionesCheques', 'url'=>array('create')),
	array('label'=>'Manage OperacionesCheques', 'url'=>array('admin')),
);
?>

<h1>Operaciones Cheques</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
