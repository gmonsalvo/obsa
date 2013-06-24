<?php
$this->breadcrumbs=array(
	'Presupuestos Cheques',
);

$this->menu=array(
	array('label'=>'Create PresupuestosCheques', 'url'=>array('create')),
	array('label'=>'Manage PresupuestosCheques', 'url'=>array('admin')),
);
?>

<h1>Presupuestos Cheques</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
