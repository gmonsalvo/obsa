<?php
//obtenemos el valor de tasa de cambio del sistema para la moneda Actual
$tasaCambio = "0.00";
?>
<script>
    function mostrarResumen(){
        var obj2=$("#res").find("div.portlet-content");
        var tipoOperacion=$("#OperacionesCambio_tipoOperacion option:selected").text();
        var moneda;
        if($("#OperacionesCambio_monedaId").val()==1)
            moneda = "U$D";
        else
            if($("#OperacionesCambio_monedaId").val()==4)
                moneda = "E";
        var monto=$("#OperacionesCambio_monto").val();
        var tasaCambio=$("#OperacionesCambio_tasaCambio").val();
        var total=parseFloat(tasaCambio)*parseFloat(monto);
        if(tipoOperacion!="" && moneda!="" && monto!=""){
            $("#resumen").css("display","block");
            obj2.html(tipoOperacion+" "+moneda+monto+" x "+tasaCambio+" = $"+total);
            $("#submitButton").removeAttr("disabled");
        }
    }

    function obtenerTasaCambio(){
        var id=$("#OperacionesCambio_monedaId").val()
        var tipoOperacion= $("#OperacionesCambio_tipoOperacion").val();
        //si hay alguno seleccionado
        if(tipoOperacion!='' && $("#OperacionesCambio_monedaId").val()!=""){
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('monedas/getTasa') ?>",
                data:{'tipoOperacion':tipoOperacion,'id':id},
                dataType: 'Text',
                success:function(data){
                    $("#OperacionesCambio_tasaCambio").val(data);
                }
            });
        }
        else
        {
            $("#OperacionesCambio_tasaCambio").val("0");
        }
    }

</script>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'operaciones-cambio-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Los Campos con <span class="required">*</span> son Obligatorios.</p>

    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td>
                <?php
                echo $form->labelEx($model, 'fecha');
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
                        'value' => date("d/m/Y"),
                        'readonly' => "readonly",
                        'style' => 'height:20px;',
                        'onChange' => 'js:$("#fecha").focus()',
                    )
                        )
                );
                ?>
            </td>
            <td colspan="2">
                <?php echo $form->labelEx($model, 'clienteId'); ?>
                <?php
                $this->widget('EJuiAutoCompleteFkField', array(
                    'model' => $model,
                    'attribute' => 'clienteId', //the FK field (from CJuiInputWidget)
                    // controller method to return the autoComplete data (from CJuiAutoComplete)
                    'sourceUrl' => Yii::app()->createUrl('/clientes/buscarRazonSocial'),
                    // defaults to false.  set 'true' to display the FK field with 'readonly' attribute.
                    'showFKField' => true,
                    // display size of the FK field.  only matters if not hidden.  defaults to 10
                    'FKFieldSize' => 15,
                    'relName' => 'cliente', // the relation name defined above
                    'displayAttr' => 'razonSocial', // attribute or pseudo-attribute to display
                    // length of the AutoComplete/display field, defaults to 50
                    'autoCompleteLength' => 40,
                    // any attributes of CJuiAutoComplete and jQuery JUI AutoComplete widget may 
                    // also be defined.  read the code and docs for all options
                    'options' => array(
                        // number of characters that must be typed before 
                        // autoCompleter returns a value, defaults to 2
                        'minLength' => 1,
                    ),
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->error($model, 'fecha'); ?></td>
            <td><?php echo $form->error($model, 'clienteId'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'tipoOperacion'); ?>
                <?php echo $form->dropDownList($model, 'tipoOperacion', $model->getTypeOptions(), array('prompt' => 'Seleccione un Tipo de Operacion', 'onchange' => '{ obtenerTasaCambio(); }')); ?>
            </td>
            <td>
                <?php echo $form->labelEx($model, 'monedaId'); ?>
                <?php 
                $criteria=new CDbCriteria();
                $criteria->condition="id!=2";                  
                echo $form->dropDownList($model, 'monedaId', CHtml::listData(Monedas::model()->findAll($criteria), 'id', 'denominacion'), array('prompt' => 'Seleccione un Tipo de Moneda', 'onchange' => '{ obtenerTasaCambio(); }')); ?>
            </td>
            <td>
                <?php echo $form->labelEx($model, 'monto'); ?>
                <?php echo $form->textField($model, 'monto', array('size' => 15, 'maxlength' => 15)); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->error($model, 'tipoOperacion'); ?></td>
            <td><?php echo $form->error($model, 'monedaId'); ?></td>
            <td><?php echo $form->error($model, 'monto'); ?></td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'tasaCambio'); ?>
                <?php echo $form->textField($model, 'tasaCambio', array('size' => 15, 'maxlength' => 15,'readonly'=>'readonly')); ?>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo $form->error($model, 'tasaCambio'); ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <div class="row buttons">
                    <?php
                    echo CHtml::button("Resumen de la Operacion", array("onclick" => "mostrarResumen()"));
                    ?>
                </div>
            </td>
            <td><div id="resumen" style="display:none">
                    <div id="res" class="portlet">
                        <div class="portlet-decoration">
                            <div class="portlet-title">Detalle de la operacion</div>
                        </div>
                        <div class="portlet-content"> ho</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios', array("disabled" => "disabled","id"=>"submitButton")); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->