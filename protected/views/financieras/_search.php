<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tasaPromedio'); ?>
		<?php echo $form->textField($model,'tasaPromedio',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'diasClearing'); ?>
		<?php echo $form->textField($model,'diasClearing'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tasaPesificacion'); ?>
		<?php echo $form->textField($model,'tasaPesificacion',array('size'=>5,'maxlength'=>5)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'responsables'); ?>
		<?php echo $form->textField($model,'responsablesBusqueda',array('size'=>45,'maxlength'=>45)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'productos'); ?>
		<?php echo $form->textField($model,'productosBusqueda',array('size'=>45,'maxlength'=>45)); ?>
	</div>
	<!--
	<div class="row">
		<?php echo $form->label($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
	</div>
	-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->