<?php

$this->menu = array(
    array('label' => 'Nuevo Flujo de Fondos', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('flujo-fondos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<h1>Flujo de Fondos</h1>
<?php Yii::import('application.components.SaldoColumnFlujoFondos');?>
<div>
    <?php
    echo CHtml::dropDownList("cuentas", "0", CHtml::listData(Cuentas::model()->findAll(), 'id', 'nombre'), array(
        'prompt' => 'Seleccione una cuenta',
    ));
    ?>
    Desde:
    <?php
    $fecha = Date('d/m/Y');
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaIni',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaIni',
            'readonly' => "readonly",
            'onChange' => 'js:$("#fechaIni").focus()',
            'style' => 'height:20px;',
            'value' => $fecha
        )
            )
    );
    ?>
    Hasta: 
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaFin',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
            //'defaultDate' => '01/08/2012',
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaFin',
            'readonly' => "readonly",
            'onChange' => 'js:$("#fechaFin").focus()',
            'style' => 'height:20px;'
            
        )
            )
    );
    ?>
</div>
<script>
    //seteo fecha por defecto dia de hoy
$("#fechaIni").val("<?php echo Date("d/m/Y")?>");
$("#fechaFin").val("<?php echo Date("d/m/Y")?>");

</script>
<?php
echo CHtml::ajaxButton('Buscar',
        //Yii::app()->createUrl("cheques/filtrar", array("prueba"=>'$("#fechaIni").val()',)),
        CHtml::normalizeUrl(array('flujoFondos/gridMayorCuentas', 'render' => false)), array(
    'type' => 'GET',
    'data' => array(
        'fechaIni' => 'js:$("#fechaIni").val()',
        'fechaFin' => 'js:$("#fechaFin").val()',
        'cuentaId' => 'js:$("#cuentas").val()'
    ),
    'dataType' => 'text',
    'success' => 'js:function(data){
					$("#gridFlujofondos").html(data);
					}',
))
?>

<div id="gridFlujofondos">
    <?php
    $this->renderPartial('_gridFlujoFondos', array('model' => new FlujoFondos,
        'dataProvider' => FlujoFondos::model()->searchByDateAndCuenta(Date("Y-m-d"), Date("Y-m-d")),
    ));
    ?>

</div>
