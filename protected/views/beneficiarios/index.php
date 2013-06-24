<?php
$this->breadcrumbs=array(
	'Beneficiarioses',
);

$this->menu=array(
	array('label'=>'Create Beneficiarios', 'url'=>array('create')),
	array('label'=>'Manage Beneficiarios', 'url'=>array('admin')),
);
?>

<h1>Beneficiarioses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
