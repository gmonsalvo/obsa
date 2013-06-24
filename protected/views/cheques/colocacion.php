<?php
$this->breadcrumbs=array(
	'Cheques'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cheques', 'url'=>array('index')),
	array('label'=>'Manage Cheques', 'url'=>array('admin')),
);
?>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<b>Cheques en Cartera</b>";
		    $this->endWidget();
?>

		<?php echo CHtml::dropDownList("drop","0",$model->listData($model->findAllByAttributes(array('estado'=>"0")), 'id', array('0'=>'numeroCheque','1'=>'endosante')),
		array(
			'prompt'=>'Seleccione un cheque',
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('cheques/viewCheque'), //url to call.
				'update'=>'#viewCheque', //selector to update
				'data'=>array('id'=>'js:$("#drop").val()'), 
			)
			));	
		?>
		<div id='viewCheque'></div> 

	