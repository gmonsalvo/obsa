<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento')); ?>:</b>
	<?php echo CHtml::encode($data->documento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('denominacion')); ?>:</b>
	<?php echo CHtml::encode($data->denominacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion')); ?>:</b>
	<?php echo CHtml::encode($data->direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('localidadId')); ?>:</b>
	<?php echo CHtml::encode($data->localidadId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('provinciaId')); ?>:</b>
	<?php echo CHtml::encode($data->provinciaId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sucursalId')); ?>:</b>
	<?php echo CHtml::encode($data->sucursalId); ?>
	<br />

	*/ ?>

</div>