<?php $clienteId = ''; ?>

<script>

    // window.onbeforeunload = function () {
    //     return "prueba";
    // }

    var montoPorAsignar=<?php echo $operacionCheque->montoNetoTotal ?>;

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
                    var montoCheques=data-$("#OrdenesPago_porcentajePesificacion").val()/100*data;
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
        var monto=montoPorAsignar-$("#montoCheques").val();
        var monto=Math.round(monto*100)/100;
        x=monto.toFixed(2);
        $("#montoEfectivo").val(x);
        if(monto<0)
        {
            alert("El monto asignado supera al monto a pagar");
            $("#submitBoton").attr('disabled','disabled');
        }
        else
            $("#submitBoton").removeAttr('disabled');
        //$("#OrdenesPago_monto").val(monto);
        //    if($("#OrdenesPago_monto").val()==(parseFloat($("#montoCheques").val())+parseFloat($("#montoEfectivo").val()))
        //        $())
        //$("#OrdenesPago_monto").val(parseFloat($("#montoCheques").val())+parseFloat($("#montoEfectivo").val()));
    }

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
        'action' => Yii::app()->createUrl("/ordenesPago/create")
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <table>
        <tr>
            <td><?php echo $form->labelEx($model, 'fecha'); ?></td>
            <td><?php echo $form->labelEx($model, 'clienteId'); ?></td>
            <td colspan="2"><?php echo $form->labelEx($model, 'descripcion'); ?></td>
        </tr>
        <tr>
            <td>
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
            </td>
            <td><?php echo CHtml::textField("cliente", $operacionCheque->productoCtaCte->cliente->razonSocial, array('readonly' => 'readonly')); ?></td>
            <td colspan="2"><?php echo $form->textField($model, 'descripcion', array('size' => 60, 'maxlength' => 100, 'value' => 'Compra de cheques')); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'porcentajePesificacion'); ?></td>
            <td><?php echo CHtml::label('Monto Efectivo', 'montoEfectivo'); ?></td>
            <td><?php echo CHtml::label('Monto en Cheques', 'montoCheques'); ?></td>
            <td><?php echo $form->labelEx($model, 'monto'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->textField($model, 'porcentajePesificacion', array("value" => $operacionCheque->productoCtaCte->cliente->tasaPesificacionTomador)) ?></td>
            <td><?php echo CHtml::textField('montoEfectivo', $operacionCheque->montoNetoTotal, array('id' => 'montoEfectivo', 'size' => 15, 'maxlength' => 15, 'onblur' => 'Recalcular();')); ?></td>
            <td><?php echo CHtml::textField('montoCheques', 0, array('id' => 'montoCheques', 'size' => 15, 'maxlength' => 15, 'readonly' => 'readonly')); ?></td>
            <td><?php echo $form->textField($model, 'monto', array('size' => 15, 'maxlength' => 15, 'value' => $operacionCheque->montoNetoTotal, 'readonly' => 'readonly')); ?></td>
        </tr>
    </table>

<?php echo $form->hiddenField($model, 'clienteId', array('value' => $operacionCheque->productoCtaCte->cliente->id)); ?>
<?php echo CHtml::hiddenField('chequesSeleccionados', '', array('id' => 'chequesSeleccionados')); ?>
<?php echo CHtml::hiddenField('clienteId', $operacionCheque->productoCtaCte->cliente->id, array('id' => 'clienteId')); ?>
<?php echo CHtml::hiddenField('operacionChequeId', $operacionCheque->productoCtaCte->cliente->id, array('id' => 'operacionChequeId')); ?>

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
        'estado' => array(Cheques::TYPE_EN_CARTERA_COLOCADO, Cheques::TYPE_EN_CARTERA_SIN_COLOCAR),
        'operacionChequeId' => $operacionCheque->id
    ),
    'dataType' => 'text',
    'success' => 'js:function(data){
					$("#grid").html(data);
					}',
))
?>

<div id='grid'><?php
        $chequesId=array();
        foreach ($operacionCheque->cheques as $cheque)
            $chequesId[]=$cheque->id;
$dataProvider = $cheques->searchChequesByEstado(array(Cheques::TYPE_CORRIENTE, Cheques::TYPE_EN_CARTERA_COLOCADO),$chequesId); //tipo de cheque en cartera colocado
$dataProvider->setPagination(false);
$this->renderPartial('/cheques/chequesFormaPago', array('cheques' => $cheques,
    'dataProvider' => $dataProvider,
));

?>
</div>

<div class="row buttons">
<?php echo CHtml::submitButton('Crear', array("id" => "submitBoton")); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->