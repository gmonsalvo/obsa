<?php
$this->breadcrumbs=array(
	'Perfiles',
);

$this->menu=array(
	array('label'=>'Nuevo Perfil', 'url'=>array('create')),
	array('label'=>'Listar Perfiles', 'url'=>array('admin')),
);
?>

<h1>Perfiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
