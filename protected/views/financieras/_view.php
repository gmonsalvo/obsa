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

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tasaPromedio')); ?>:</b>
	<?php echo CHtml::encode($data->tasaPromedio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('diasClearing')); ?>:</b>
	<?php echo CHtml::encode($data->diasClearing); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tasaPesificacion')); ?>:</b>
	<?php echo CHtml::encode($data->tasaPesificacion); ?>
	<br />
	
	<b><?php echo CHtml::encode('Responsables'); ?>:</b>
	<br/>
	<?php /*echo CHtml::encode($data->responsables->id);*/
		foreach($data->responsables as $responsable) {
			echo CHtml::encode($responsable['nombre'].' - Cel.: '.$responsable['celular'].' - E-Mail: '.$responsable['email']);
			echo '<br>';
		}
	?>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	*/ ?>

</div>