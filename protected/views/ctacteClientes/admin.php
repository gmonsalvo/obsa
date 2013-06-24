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

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ctacte-clientes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('ponerFoco', '$("#'. CHtml::activeId($model,'clienteId') . '").focus();');
?>

<h1>Movimientos de Cuentas Corrientes</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
Yii::import('application.components.SaldoColumn');

$this->widget('GridViewStyle', array(
        'id'=>'ctacte-clientes-grid',
        'dataProvider'=>$model->search(),
        'rowCssStyleExpression'=>'$data->tipoMov == 0 ? ($data->saldoAcumulado >= 0 ? "background-color: #e6f1f5" : "background-color: #FF8383") : ($data->saldoAcumulado >= 0 ? "background-color:#b9dd94" : "background-color:#FF8383")',
        'columns'=>array(
            'id',
            'fecha',
            'descripcion',
            array(
                'name' => 'monto',
                'header' => 'Credito',
                'value' => 'Utilities::MoneyFormat($data->tipoMov == 0 ? "$data->monto":"0")',
                'htmlOptions'=>array('style'=>'text-align: right'),
            ),
            array(
                'name' => 'monto',
                'header' => 'Debito',
                'value' => 'Utilities::MoneyFormat($data->tipoMov == 1 ? "$data->monto":"0")',
                'htmlOptions'=>array('style'=>'text-align: right'),
            ),
            array(
                'name' => 'saldoAcumulado',
                'header' => 'Saldo Acumulado',
                'value' => 'Utilities::MoneyFormat($data->saldoAcumulado)',
                'htmlOptions'=>array('style'=>'text-align: right'),
            ),
            // array(
            //  'header' => 'Saldo',
            //  'class'  => 'SaldoColumn',
            //  'htmlOptions'=>array('style'=>'text-align: right'),
            // ),
        ),
    ));

?>


<?php
/*
    
    echo CHtml::ajaxButton('Filtrar',
            //Yii::app()->createUrl("cheques/filtrar", array("prueba"=>'$("#fechaIni").val()',)),
            CHtml::normalizeUrl(array('ctacteClientes/filtrar', 'render' => false)), array(
        'type' => 'GET',
        'data' => array(
            'fechaIni' => 'js:$("#fechaIni").val()',
            'fechaFin' => 'js:$("#fechaFin").val()',
            'clienteId' => $model->clienteId
        ),
        'dataType' => 'text',
        'success' => 'js:function(data){
					$("#resultados").html(data);
					}',
    ))
    */
    ?>
  


