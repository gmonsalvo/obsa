<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('celular')); ?>:</b>
	<?php echo CHtml::encode($data->celular); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fijo')); ?>:</b>
	<?php echo CHtml::encode($data->fijo); ?>
	<br />
	
	<b><?php echo CHtml::encode('Financieras'); ?>:</b>
	<br/>
	<?php /*echo CHtml::encode($data->responsables->id);*/
		foreach($data->financieras as $financiera) {
			echo CHtml::encode($financiera['nombre'].' - '.$financiera['direccion'].' - '.$financiera['telefono']);
			echo '<br>';
		}
	?>
	<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />
	-->

</div>