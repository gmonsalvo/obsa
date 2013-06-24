<style>
    .grid-view table.items tr.chequelevantar {
        background: none repeat scroll 0 0 #9FF781;
    }

    #grid{
        position:relative;
        overflow: auto;
        height: 400px;
    }
</style>

<script>
    function MostrarCheque(){
        var listaCheques=$.fn.yiiGridView.getSelection("cheques-grid");
        /*var checks=document.getElementsByTagName("cheques-grid_c0[]");
        $("input[type=checkbox]").each(function() {
            alert($(this).val());
    });
        $("input:checked").each(function() {
                alert(this.checked());
        })
        alert($("input:checked"));
        var keys = $("#cheques-grid > div.keys > span");

        $("#cheques-grid > table > tbody > tr").each(function(i)
        {
                if($(this).hasClass("selected"))
                {
                        checkBoxs[0]=$(this).children(":nth-child(1)").text();
                        //$("#Pacjenci_patientID").val(keys.eq(i).text());
                }
        });
         */
        //alert(checkBoxs);


        var chequesId='';
        if(listaCheques.length!=0)
        {
            for(var i=0;i<listaCheques.length;i++)
            {
                chequesId=chequesId + ';' + listaCheques[i];
            }
            $("#detallesPesificaciones").val(chequesId);

            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('cheques/getMontos') ?>",
                data:{'chequesId':$.fn.yiiGridView.getSelection("cheques-grid")},
                dataType: 'Text',
                success:function(data){
                    $("#monto").val(data);
                    RecalcularMonto();
                }
            });
    }
    else
    {
        //pongo en 0 de nuevo para que no me deje grabar
        $("#monto").val('0');
        $("#total").val('0');
        $("#btnSubmit").attr('disabled','disabled');
    }

}
function CargarPesificador()
{
    //alert($("#Pesificaciones_pesificadorId").val());
    $.ajax({
        type: 'POST',
        url: "<?php echo CController::createUrl('pesificadores/getPesificador') ?>",
        data:{'pesificadorId':$("#Pesificaciones_pesificadorId").val()},
        dataType: 'Text',
        success:function(data){
            $("#porcentajePesific").val(data);
            RecalcularMonto();
        }
    });

}

function RecalcularMonto()
{
    if($("#porcentajePesific").val()!=0 && $("#monto").val()!=0)
    {
        $("#btnSubmit").removeAttr('disabled');
        var total=$("#monto").val()-$("#monto").val()*$("#porcentajePesific").val()/100;
        $("#total").val(total);
    }
    else
    {
        $("#total").val("0");
        $("#btnSubmit").attr('disabled','disabled');
    }


}

</script>

<?php
$this->breadcrumbs = array(
    'Pesificaciones' => array('admin'),
    'Nueva',
);

$this->menu = array(
    array('label' => 'Listar Pesificaciones', 'url' => array('admin')),
);
?>

<h1>Pesificaciones</h1>

<?php //echo var_dump($valor) ?>

<div class="form">

<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'pesificaciones-form',
        'enableAjaxValidation' => false,
    ));
?>

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
        'readonly' => "readonly",
        'style' => 'height:20px;',
			'value' => Date('d/m/Y'),
        )
    ));
?>
<?php echo $form->error($model, 'fecha'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pesificadorId'); ?>
        <?php
        echo $form->dropDownList($model, 'pesificadorId', CHtml::listData(Pesificadores::model()->findAll(), 'id', 'denominacion'), array(
            'prompt' => 'Seleccione un pesificador',
            'onchange' => 'js:CargarPesificador()',
                )
        );
        ?>
    <?php echo $form->error($model, 'pesificadorId'); ?>
    </div>
    <?php echo CHtml::hiddenField('detallesPesificaciones', '', array('id' => 'detallesPesificaciones')); ?>
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
        ),
        'dataType' => 'text',
        'success' => 'js:function(data){
					$("#grid").html(data);
					}',
    ))
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Crear', array('id'=>'btnSubmit','disabled'=>'disabled')); ?>
    </div>

    <div id='grid'><?php
        $dataProvider = $cheques->searchChequesByEstado(array(Cheques::TYPE_CORRIENTE,Cheques::TYPE_EN_CARTERA_COLOCADO)); //tipo de cheque en cartera colocado
        $dataProvider->setPagination(false);
        $this->renderPartial('/cheques/chequesEnCartera', array('cheques' => $cheques,
            'dataProvider' => $dataProvider,
        ));
        ?>
    </div>

    <table>
        <tr>
            <td><?php echo CHtml::label('Monto', 'monto'); ?></td>
            <td><?php echo CHtml::textField('monto', '0', array("id" => "monto",'readonly'=>'readonly')); ?></td>
            <td><?php echo CHtml::label('% Pesificacion', 'porcentajePesific'); ?></td>
            <td><?php echo CHtml::textField('porcentajePesific', '0', array("id" => "porcentajePesific",'readonly'=>'readonly')); ?></td>
            <td><?php echo CHtml::label('Total', 'total'); ?></td>
            <td><?php echo CHtml::textField('total', '0', array("id" => "total", 'readonly'=>'readonly')); ?></td>
        </tr>
    </table>

<?php $this->endWidget(); ?>

</div><!-- form -->