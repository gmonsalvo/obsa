<div class="search-form"><b>Cliente:</b> 
    <?php //echo var_dump(CHtml::listData(Cuentas::model()->findAll(), 'id', 'nombre'));?>
    <?php
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'name' => 'city',
        'source' => Yii::app()->createUrl('/clientes/buscarRazonSocial'),
        // additional javascript options for the autocomplete plugin
        'options' => array(
            'minLength' => '2',
            'select' => "js:function(event, ui) { 
            $('#clienteId').val(ui.item.id); // ui.item.whatYouReturnInController
            }"
        ),
        'htmlOptions' => array(
            'style' => 'height:20px;'
        ),
    ));
    ?>


<?php
echo CHtml::ajaxButton('Informe',
        //Yii::app()->createUrl("cheques/filtrar", array("prueba"=>'$("#fechaIni").val()',)),
        CHtml::normalizeUrl(array('clientes/getInforme', 'render' => false)), array(
    'type' => 'GET',
    'data' => array(
        'clienteId' => 'js:$("#clienteId").val()'
    ),
    'dataType' => 'text',
    'success' => 'js:function(data){    
                                        $("#result").css("display", "block");
					$("#result").html(data);
                                        $("#botonAjax").removeAttr("disabled");
					}',
))
?>

<input type="hidden" id="clienteId" value ="">
<?php
echo CHtml::ajaxButton('Exportar a PDF', CHtml::normalizeUrl(array('clientes/exportPDF', 'render' => false)), array(
    'type' => 'GET',
    'data' => array(
        'clienteId' => 'js:$("#clienteId").val()',
        'export' => true
    ),
    'dataType' => 'text',
    'success' => 'js:function(data){    
                                        $("#result").css("display", "block");
                                        div =  "<div></div>";
					$(div).html(data);
                                        
                                        
					}',
    array("id" => "botonAjax", "disabled" => "disabled")
))
?>
</div>
<div id="result" style="display:none">
    <?php
    //inicializacion del grid con datos vacios
    $this->renderPartial('viewInforme', array(
        'arrayDataProvider' => new CArrayDataProvider(array()),
        'montoColocadoTotal' => 0,
        'valorActualTotal' => 0,
        'saldo' => 0,
        'resumen' => ''
    ));
    ?>

</div>
