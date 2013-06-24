<?php
$this->breadcrumbs=array(
	'Colocaciones'=>array('create'),
	'Reemplazo',
);

$this->menu=array(
	array('label'=>'Listado Colocaciones', 'url'=>array('create')),
);
?>


<?php
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<h2><b>Reemplazo de cheques</b></h2>";
		    $this->endWidget();
?>

<?php echo $this->renderPartial('_Recolocacionesform', array('model'=>$model,'cheques'=>$cheques,'clientes'=>$clientes)); ?>