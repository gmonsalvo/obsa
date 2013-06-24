<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuentaId')); ?>:</b>
        <?php echo CHtml::encode($data->cuenta->nombre) ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conceptoId')); ?>:</b>
	<?php echo CHtml::encode($data->concepto->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoFlujoFondos')); ?>:</b>
	<?php echo CHtml::encode($data->getTypeDescription()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->monto)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('origen')); ?>:</b>
	<?php echo CHtml::encode($data->origen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identificadorOrigen')); ?>:</b>
	<?php echo CHtml::encode($data->identificadorOrigen); ?>
	<br />

</div>