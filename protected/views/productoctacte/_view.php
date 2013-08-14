<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombreModelo')); ?>:</b>
	<?php echo CHtml::encode($data->nombreModelo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pkModeloRelacionado')); ?>:</b>
	<?php echo CHtml::encode($data->pkModeloRelacionado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productoId')); ?>:</b>
	<?php echo CHtml::encode($data->productoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />


</div>