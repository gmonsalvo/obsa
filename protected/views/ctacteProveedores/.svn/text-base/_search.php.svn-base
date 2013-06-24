<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="search-button">
	<?php echo CHtml::activeDropDownList($model,'proveedorId',
		CHtml::listData(Proveedores::model()->findAll(), 
		'id', 'denominacion'),array('empty'=>'Seleccione un Proveedor','submit'=>''));
	?>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->