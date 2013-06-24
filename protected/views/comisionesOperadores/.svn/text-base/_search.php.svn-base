<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
	<?php echo $form->label($model,'operadorId'); ?>
	<?php
	    echo CHtml::activeDropDownList($model,'operadorId',
		CHtml::listData(Operadores::model()->findAll(),
		'id', 'apynom'),array('empty'=>'Seleccione un Operador'));
	?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->