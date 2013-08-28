<?php
	$this->widget('GridViewStyle', array(
        'id'=>'ctacte-grid',
        'dataProvider'=>$dataProvider,
        'rowCssStyleExpression'=>'$data->tipoMov == 0 ? "background-color: #9FF781" : "background-color:#F6CECE"',
        'columns'=>array(
            'id',
			'fecha',
			'descripcion',
			array(
				'name' => 'monto',
				'header' => 'Credito',
				'value' => 'Yii::app()->numberFormatter->format("#,##0.00",($data->tipoMov == 0) ? "$data->monto":"")',
				'htmlOptions'=>array('style'=>'text-align: right'),
			),
			array(
				'name' => 'monto',
				'header' => 'Debito',
				'value' => 'Yii::app()->numberFormatter->format("#,##0.00",($data->tipoMov == 1) ? "$data->monto":"")',
				'htmlOptions'=>array('style'=>'text-align: right'),
			),
			array(
				'name' => 'saldoAcumulado',
				'header' => 'Saldo Acumulado',
				'value' => '$data->saldoAcumulado'
			),
			// array(
			// 	'header' => 'Saldo',
			// 	'class'  => 'SaldoColumn',
			// 	'htmlOptions'=>array('style'=>'text-align: right'),
			// ),
		),
	));

?>
<div>
	<?php
		$saldo = $model->getSaldoAcumuladoActual();
		if ($saldo == 0)
		{
			echo "<div align='right'><b><font color='navy'>Saldo: 0,00</font></b></div>";
		}
		elseif ($saldo > 0)
		{
			echo "<div align='right'><b><font color='green'>Saldo: ".Yii::app()->numberFormatter->format("#,##0.00", $saldo)."</font></b></div>";
		}
		elseif ($saldo < 0)
		{
			echo "<div align='right'><b><font color='red'>Saldo: ".Yii::app()->numberFormatter->format("#,##0.00", $saldo)."</font></b></div>";
		}

?>
</div>
