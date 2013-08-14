<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoMov')); ?>:</b>
	<?php echo CHtml::encode($data->tipoMov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productoCtaCteId')); ?>:</b>
	<?php echo CHtml::encode($data->productoCtaCteId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conceptoId')); ?>:</b>
	<?php echo CHtml::encode($data->conceptoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode($data->monto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('saldoAcumulado')); ?>:</b>
	<?php echo CHtml::encode($data->saldoAcumulado); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('origen')); ?>:</b>
	<?php echo CHtml::encode($data->origen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identificadorOrigen')); ?>:</b>
	<?php echo CHtml::encode($data->identificadorOrigen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sucursalId')); ?>:</b>
	<?php echo CHtml::encode($data->sucursalId); ?>
	<br />

	*/ ?>

</div>