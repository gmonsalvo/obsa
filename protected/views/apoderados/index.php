<?php
$this->breadcrumbs=array(
	'Apoderadoses',
);

$this->menu=array(
	array('label'=>'Create Apoderados', 'url'=>array('create')),
	array('label'=>'Manage Apoderados', 'url'=>array('admin')),
);
?>

<h1>Apoderadoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
