<?php
$this->breadcrumbs=array(
	'Ctactes',
);

$this->menu=array(
	array('label'=>'Create Ctacte', 'url'=>array('create')),
	array('label'=>'Manage Ctacte', 'url'=>array('admin')),
);
?>

<h1>Ctactes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
