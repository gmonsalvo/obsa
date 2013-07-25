<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'financieras-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaPromedio'); ?>
		<?php echo $form->textField($model,'tasaPromedio',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'tasaPromedio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'diasClearing'); ?>
		<?php echo $form->textField($model,'diasClearing'); ?>
		<?php echo $form->error($model,'diasClearing'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tasaPesificacion'); ?>
		<?php echo $form->textField($model,'tasaPesificacion',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'tasaPesificacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->error($model,'responsables'); ?>
		<?php
			$model->refresh();
		
			$ids = array();
			 
			if ($model->responsables) {
				//echo var_dump($model->responsables);
				foreach($model->responsables as $record)
					//echo var_dump($record);
					if ($record)
						$ids[] = $record->id ;
			}
			
			$responsablesDisponibles = Responsables::model()->responsablesDisponibles($ids);
			
			$this->widget('application.extensions.widgets.multiselects.XMultiSelects',array(
			    'leftTitle'=>'Disponibles',
			    'leftName'=>'disponibles',
			    'leftList'=>CHtml::listData($responsablesDisponibles->getData(),'id','nombre'),
			    'rightTitle'=>'Seleccionados',
			    'rightName'=>'select_right[]',
			    'rightList'=>CHtml::listData($model->responsables,'id','nombre'),
			    'size'=>10,
			    'width'=>'200px',
			));
		?>
	</div>	


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->