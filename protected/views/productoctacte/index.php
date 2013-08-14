<?php
$this->breadcrumbs=array(
	'Productoctactes',
);

$this->menu=array(
	array('label'=>'Create Productoctacte', 'url'=>array('create')),
	array('label'=>'Manage Productoctacte', 'url'=>array('admin')),
);
?>

<h1>Productoctactes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
