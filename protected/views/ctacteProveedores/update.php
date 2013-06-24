<?php
$this->breadcrumbs=array(
	'Ctacte Proveedores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CtacteProveedores', 'url'=>array('index')),
	array('label'=>'Create CtacteProveedores', 'url'=>array('create')),
	array('label'=>'View CtacteProveedores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CtacteProveedores', 'url'=>array('admin')),
);
?>

<h1>Update CtacteProveedores <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>