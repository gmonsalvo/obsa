<?php
$this->breadcrumbs=array(
	'Financieras',
);

$this->menu=array(
	array('label'=>'Nueva Financiera', 'url'=>array('create')),
	array('label'=>'Administrar Financieras', 'url'=>array('admin')),
);
?>

<h1>Financierases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
