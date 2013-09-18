<?php
$this->breadcrumbs = array(
    'Ordenes Pagos' => array('/ordenesPago/admin'),
    'Crear',
);

$this->menu = array(
    array('label' => 'Listar OrdenesPago', 'url' => array('/ordenesPago/admin')),
);
?>

<script>

    function Habilitar(id){
        if($.fn.yiiGridView.getSelection(id)!=""){
            $("#montoRetiro").removeAttr('disabled');
            $("#btnRetirar").removeAttr('disabled');
            $("#idCliente").val($.fn.yiiGridView.getSelection(id));
        }
        else{
            $("#montoRetiro").attr('disabled','disabled');
            $("#btnRetirar").attr("disabled","disabled");
            $("#idCliente").val('');
        }
    }

    function validate(form)
    {
        var montoRetiro=parseFloat($("#monto").val());
        //var comparar=parseFloat($("#saldoColocaciones").val())+parseFloat($("#saldoCtaCte").val());
        var montoDisponible=parseFloat($("#saldoCtaCte").val());
        var montoPermitidoDescubierto=parseFloat($("#montoPermitidoDescubierto").val());
        var saldoColocaciones = parseFloat($("#saldoColocaciones").val());
        if(montoRetiro>(montoDisponible+montoPermitidoDescubierto+saldoColocaciones))
        {
            alert("El monto a retirar es mayor que la suma del saldo en cta cte y el monto permitido descubierto");
            return false;
        }
        return true;
    }

    function MostrarInformacion(){
        if($("#OrdenesPago_clienteId").val()==""){
            return false;
        } else {
            $.post("/obsa/index.php/clientes/getSaldos?render=false",{"id":$("#OrdenesPago_clienteId").val(), "productoId":$("#OrdenesPago_productoId").val()},function(data){
            if(data==""){
                $(".oculto").css("display","none");
                $("#botonSubmit").attr("disabled","disabled");
            }else
            {
                var datos=jQuery.parseJSON(data);
                $(".oculto").css("display","block");
                $("#saldoCtaCte").val(datos.saldo);
                $("#saldoColocaciones").val(datos.saldoColocaciones);
                $("#montoPermitidoDescubierto").val(datos.montoPermitidoDescubierto);

                $("#botonSubmit").removeAttr("disabled");
            }
            });
        }
    }

</script>
<style>
    .oculto{display: none}
</style>

<h1>Retiro de Fondos</h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ordenes-pago-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'action' => Yii::app()->createUrl("/ordenesPago/retirarFondos"),
        'htmlOptions' => array('onSubmit' => 'return validate(this)')
            ));
    ?>

    <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

    <?php echo $form->errorSummary($model); ?>

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
        <?php
        echo $form->labelEx($model, 'clienteId');
        $this->widget('CustomEJuiAutoCompleteFkField', array(
            'model' => $model,
            'attribute' => 'clienteId', //the FK field (from CJuiInputWidget)
            // controller method to return the autoComplete data (from CJuiAutoComplete)
            'sourceUrl' => Yii::app()->createUrl('/clientes/buscarRazonSocial',
                                    array("tipo[0]"=>  Clientes::TYPE_INVERSOR,"tipo[1]"=>Clientes::TYPE_TOMADOR_E_INVERSOR)),
            // defaults to false.  set 'true' to display the FK field with 'readonly' attribute.
            'showFKField' => true,
            // display size of the FK field.  only matters if not hidden.  defaults to 10
            'FKFieldSize' => 15,
            'relName' => 'cliente', // the relation name defined above
            'displayAttr' => 'razonSocial', // attribute or pseudo-attribute to display
            // length of the AutoComplete/display field, defaults to 50
            'autoCompleteLength' => 40,
//            'javascript' => "alert('holaaa');",
            // any attributes of CJuiAutoComplete and jQuery JUI AutoComplete widget may
            // also be defined.  read the code and docs for all options
            //'select' => "MostrarInformacion()",
            'options' => array(
                // number of characters that must be typed before
                // autoCompleter returns a value, defaults to 2
                'minLength' => 1,

            ),
            'onSelectScript'=>CHtml::ajax(array('type'=>'POST', 'url'=>array("ordenesPago/cargarProductosCliente"), 'update'=>'#OrdenesPago_productoId')),
        ));
        echo $form->error($model, 'clienteId');
        echo CHtml::ajaxButton('Mostrar informacion', CHtml::normalizeUrl(array('clientes/getSaldos', 'render' => false)), array(
            'type' => 'POST',
            'data' => array('id' => 'js:$("#OrdenesPago_clienteId").val()',
            ),
            'dataType' => 'text',
            'beforeSend' => 'js:function(){
                    if($("#OrdenesPago_clienteId").val()==""){
                        alert("Debe seleccionar un cliente");
                        return false;
                    }
                    return true;
                }',
            'success' => 'js:function(data){
                            if(data==""){
                                $(".oculto").css("display","none");
                                $("#botonSubmit").attr("disabled","disabled");
                            }else
                            {
                                var datos=jQuery.parseJSON(data);
                                $(".oculto").css("display","block");
                                $("#saldoCtaCte").val(datos.saldo);
                                $("#saldoColocaciones").val(datos.saldoColocaciones);
                                $("#montoPermitidoDescubierto").val(datos.montoPermitidoDescubierto);

                                $("#botonSubmit").removeAttr("disabled");
                            }
             }',
        ))
        ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'productoId'); ?>
		<?php echo $form->dropDownList($model, 'productoId', array(), array('empty' => 'Seleccionar un producto')) ?>
		<?php echo $form->error($model,'productoId'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'descripcion'); ?>
        <?php echo $form->textField($model, 'descripcion', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'descripcion'); ?>
    </div>


    <div class="row oculto">
        <?php echo CHtml::label('Saldo en cta cte', 'saldoCtaCte'); ?>
        <?php echo CHtml::textField('saldoCtaCte', 0, array('id' => 'saldoCtaCte', 'size' => 15, 'maxlength' => 15, 'readonly' => 'readonly')); ?>
    </div>
    <div class="row oculto">
        <?php echo CHtml::label('Saldo en colocaciones', 'saldoColocaciones'); ?>
        <?php echo CHtml::textField('saldoColocaciones', 0, array('id' => 'saldoColocaciones', 'size' => 15, 'maxlength' => 15, 'readonly' => 'readonly')); ?>
    </div>
   <div class="row oculto">
        <?php echo CHtml::label('Monto Permitido Descubierto', 'montoPermitidoDescubierto'); ?>
        <?php echo CHtml::textField('montoPermitidoDescubierto', 0, array('id' => 'montoPermitidoDescubierto', 'size' => 15, 'maxlength' => 15, 'readonly' => 'readonly')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'monto'); ?>
        <?php
            $this->widget("FormatCurrency",
                array(
                    "model" => $model,
                    "attribute" => "monto",
                    ));
        ?>
        <?php //echo $form->textField($model, 'monto', array('size' => 15, 'maxlength' => 15)); ?>
        <?php echo $form->error($model, 'monto'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios', array("id"=>"botonSubmit")); ?>
    </div>

    <?php $this->endWidget('ordenes-pago-form'); ?>

</div>