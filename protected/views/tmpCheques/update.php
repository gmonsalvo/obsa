<?php
$this->breadcrumbs=array(
	'Tmp Cheques'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TmpCheques', 'url'=>array('index')),
	array('label'=>'Create TmpCheques', 'url'=>array('create')),
	array('label'=>'View TmpCheques', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TmpCheques', 'url'=>array('admin')),
);
?>

<h1>Update TmpCheques <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>