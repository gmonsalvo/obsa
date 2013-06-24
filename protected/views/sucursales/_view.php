<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion')); ?>:</b>
	<?php echo CHtml::encode($data->direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comisionGeneral')); ?>:</b>
	<?php echo CHtml::encode($data->comisionGeneral); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tasaDescuentoGeneral')); ?>:</b>
	<?php echo CHtml::encode($data->tasaDescuentoGeneral); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tasaInversores')); ?>:</b>
	<?php echo CHtml::encode($data->tasaInversores); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tasaPesificacion')); ?>:</b>
	<?php echo CHtml::encode($data->tasaPesificacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('diasClearing')); ?>:</b>
	<?php echo CHtml::encode($data->diasClearing); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	*/ ?>

</div>