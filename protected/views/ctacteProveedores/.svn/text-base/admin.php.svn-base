<style>
	.grid-view table.items tr.tbrow{
		background: none repeat scroll 0 0 #9FF781;
	}	
	#grid{
		position:relative;
		overflow: auto;
		height: 400px;
	}
</style>

<?php
$this->breadcrumbs=array(
	'CtacteProveedores'=>array('admin'),
	'Administrar',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ctacte-proveedores-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Movimientos de Proveedores</h1>

<div class="row">
    <?php $this->renderPartial('_search',array('model'=>$model,));?>
</div>

<?php
if ($model->proveedorId != 0)
{
	$this->widget('GridViewStyle', array(
        'id'=>'ctacte-proveedores-grid',
        'dataProvider'=>$model->search(),
		'rowCssStyleExpression'=>'$data->tipoMov == 0 ? "background-color: #9FF781" : "background-color:#F6CECE"',
        'columns'=>array(
            'id',
			array(
				 'name'=>'tipoMov',
				 'header'=>'Tipo Mov',
				 'value'=>'$data->getTypeDescription()',
			),
			'descripcion',
    		'fecha',
            array(
				'name' => 'monto',
                'header' => 'Monto',
                'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->monto)',
                'htmlOptions'=>array('style'=>'text-align: right'),
			),
		),
	));
	
	$saldo = $model->getSaldo();
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
}
?>
