<?php
$this->breadcrumbs=array(
	'Socios',
);

$this->menu=array(
	array('label'=>'Volver a la hoja del librador', 'url'=>array('/libradores/view','id'=>$_GET['libradorId'])),
);
?>

<h1>Socios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
