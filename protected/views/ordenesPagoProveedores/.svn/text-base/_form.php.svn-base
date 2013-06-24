<?php $clienteId = ''; ?>

<script>

function AgregarImporteCheque(id)
{
    $("#chequesSeleccionados").val($.fn.yiiGridView.getSelection(id));
    if($.fn.yiiGridView.getSelection(id)!='')
        {
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('cheques/getMontos') ?>",
                data:{'chequesId':$.fn.yiiGridView.getSelection(id)},
                dataType: 'Text',
                success:function(data){
                    var montoCheques=data-$("#OrdenesPagoProveedores_porcentajePesificacion").val()/100*data;
                    $("#montoCheques").val(montoCheques);
                    Recalcular();
                    //$("#OrdenesPago_monto").val(parseFloat(data)+parseFloat($("#montoEfectivo").val()));
                    
                }
            });  
        }
    else
    {
        $("#montoCheques").val(0);
        Recalcular();
        //$("#OrdenesPago_monto").val(parseFloat($("#montoEfectivo").val()));
    }
}

function Recalcular()
{
    var monto=$("#OrdenesPagoProveedores_monto").val()-$("#montoCheques").val() - $("#montoEfectivo").val();
    //var monto=Math.round(monto*100)/100;
    //x=monto.toFixed(2);
    //$("#montoEfectivo").val(x);
    if(monto<0)
    {
        alert("El monto asignado supera al monto a pagar");
        $("#submitBoton").attr('disabled','disabled');
    }
    else
        if(monto==0)
            $("#submitBoton").removeAttr('disabled');
    //$("#OrdenesPagoProveedores_monto").val(monto);
//    if($("#OrdenesPagoProveedores_monto").val()==(parseFloat($("#montoCheques").val())+parseFloat($("#montoEfectivo").val()))
//        $())
    //$("#OrdenesPagoProveedores_monto").val(parseFloat($("#montoCheques").val())+parseFloat($("#montoEfectivo").val()));
}

//function CargarPorcentajePesificacion()
//{
//    $.ajax({
//        type: 'POST',
//        url: "<?php echo CController::createUrl('pesificadores/getPesificador') ?>",
//        data:{'pesificadorId':$("#Pesificaciones_pesificadorId").val()},
//        dataType: 'Text',
//        success:function(data){
//            $("#porcentajePesific").val(data);
//            RecalcularMonto();
//        }
//    });
//	
//}

</script>

<style>
    #grid{
        position:relative;
        overflow: auto;
    }
</style>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ordenes-pago-form',
        'enableAjaxValidation' => false,
        'action' => Yii::app()->createUrl("/ordenesPagoProveedores/create") 
            ));
    ?>

    <p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'proveedorId'); ?>
        <?php echo $form->dropDownList($model, 'proveedorId', CHtml::listData(Proveedores::model()->findAll(), 'id', 'denominacion'),
                array('prompt' => 'Seleccione un Proveedor',
//                    'onchange' => 'js:CargarPorcentajePesificacion()'
                    )); ?>
        <?php echo $form->error($model, 'proveedorId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'fecha'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            // you must specify name or model/attribute
            'model' => $model,
            'attribute' => 'fecha',
            'language' => 'es',
            'options' => array(
                'dateFormat' => 'dd/mm/yy',
                //'defaultDate'=>Date('d-m-Y'),
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'showButtonPanel' => 'true',
                'constrainInput' => 'false',
                'duration' => 'fast',
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array(
                'value' => Date("d/m/Y"),
                'readonly' => "readonly",
                'style' => 'height:20px;',
                'onChange' => 'js:$("#OrdenesPago_fecha").focus()',
            )
                )
        );
        ?>
        <?php echo $form->error($model, 'fecha'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'monto'); ?>
        <?php echo $form->textField($model, 'monto', array('size' => 15, 'maxlength' => 15, 'value' => 0)); ?>
        <?php echo $form->error($model, 'monto'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'descripcion'); ?>
        <?php echo $form->textField($model, 'descripcion', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'descripcion'); ?>
    </div>
    
    <div class="row">
        <?php //echo $form->labelEx($model, 'porcentajePesificacion'); ?>
        <?php echo $form->hiddenField($model, 'porcentajePesificacion',array("value"=>"0")) ?>
        <?php //echo $form->error($model, 'porcentajePesificacion'); ?>
    </div>

<!--    <div class="row">
        <?php echo CHtml::label('Monto Efectivo', 'montoEfectivo'); ?>
        <?php echo CHtml::textField('montoEfectivo', 0, array('id' => 'montoEfectivo', 'size' => 15, 'maxlength' => 15,'onblur'=>'Recalcular();')); ?>

    </div>

    <div class="row">
        <?php echo CHtml::label('Monto en Cheques', 'montoCheques'); ?>
        <?php echo CHtml::textField('montoCheques', 0, array('id' => 'montoCheques', 'size' => 15, 'maxlength' => 15, 'readonly' => 'readonly')); ?>
    </div>


    <?php echo CHtml::hiddenField('chequesSeleccionados', '', array('id' => 'chequesSeleccionados')); ?>
    <?php //echo CHtml::hiddenField('clienteId', $operacionCheque->clienteId, array('id' => 'clienteId')); ?>

    Fecha inicio:
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaIni',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
            //'defaultDate'=>Date('d-m-Y'),
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaIni',
            'value' => '2011-02-02',
            'readonly' => "readonly",
            'style' => 'height:20px;'
        )
            )
    );
    ?>
    &nbsp; hasta &nbsp; Fecha fin: 
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaFin',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
            //'defaultDate'=>Date('d-m-Y'),
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaFin',
            'value' => '2011-02-02',
            'readonly' => "readonly",
            'style' => 'height:20px;'
        )
            )
    );
    ?>

    <?php
    echo CHtml::ajaxButton('Filtrar',
            //Yii::app()->createUrl("cheques/filtrar", array("prueba"=>'$("#fechaIni").val()',)),
            CHtml::normalizeUrl(array('cheques/filtrar', 'render' => false)), array(
        'type' => 'GET',
        'data' => array(
            'fechaIni' => 'js:$("#fechaIni").val()',
            'fechaFin' => 'js:$("#fechaFin").val()',
            'estado' => array(Cheques::TYPE_EN_CARTERA_COLOCADO,  Cheques::TYPE_EN_CARTERA_SIN_COLOCAR),
        ),
        'dataType' => 'text',
        'success' => 'js:function(data){
					$("#grid").html(data);
					}',
    ))
    ?>

    <div id='grid'><?php
    $dataProvider = $cheques->searchChequesByEstado(array(Cheques::TYPE_EN_CARTERA_SIN_COLOCAR,  Cheques::TYPE_EN_CARTERA_COLOCADO)); //tipo de cheque en cartera colocado
    $dataProvider->setPagination(false);
    $this->renderPartial('/cheques/chequesFormaPago', array('cheques' => $cheques,
        'dataProvider' => $dataProvider,
    ));
//    ?>
    </div>-->

    <div class="row buttons">
        <?php echo CHtml::submitButton('Crear',array("id"=>"submitBoton")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->