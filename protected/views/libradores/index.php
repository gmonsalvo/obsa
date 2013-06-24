<?php
$this->breadcrumbs=array(
	'Libradores',
);

$this->menu=array(
	array('label'=>'Listar Libradores', 'url'=>array('admin')),
	array('label'=>'Nuevo Librador', 'url'=>array('create')),

);
?>

<h1>Libradores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
