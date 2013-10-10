<?php
if (isset($_POST['operadorId']) && isset($_POST['financieraId']) && isset($_POST['fecha']) && isset($_POST['productoId'])) {
    $operadorId = $_POST['operadorId'];
    $financieraId = $_POST['financieraId'];
	$productoId = $_POST['productoId'];
    $fecha = $_POST['fecha'];
} else {
    if (isset($_GET['operadorId']) && isset($_GET['financieraId']) && isset($_GET['fecha']) && isset($_GET['productoId'])) {
        $operadorId = $_GET['operadorId'];
        $financieraId = $_GET['financieraId'];
		$productoId = $_GET['productoId'];
        $fecha = $_GET['fecha'];
    } else {
        $operadorId = '';
        $financieraId = '';
		$productoId = '';
        $fecha = Date('d/m/Y');
    }
}
?>
<?php Yii::app()->clientScript->registerScript('setFocus', '$("#financieraId_lookup").focus();'); ?>
<?php Yii::app()->clientScript->registerScript('lostFocus', 
    '$("#TmpCheques_pesificacion").live("focusout",function(){
        $("#TmpCheques_numeroCheque").focus();
    });'
); ?>
    <?php Yii::app()->clientScript->registerScript('cambiarLayout', '

    $("#content").parent().parent().find(".span5 last").remove();
    $("#content").parent().parent().find(".span-22").removeClass("span-22").addClass("span-24");
    $("#content").width("950px");
    ') ;?>
<script>

    $("#fechaOperacion").val($("#OperacionesCheques_fecha").val());
    //$(".formatCurrency").formatCurrency();
    function LimpiarFormulario()
    {
        $( "#TmpCheques_numeroCheque" ).val('');
        $( "#TmpCheques_libradorId" ).val('');
        $( "#TmpCheques_montoOrigen" ).val('');
        $( "#TmpCheques_fechaPago" ).val('');
        $( "#TmpCheques_bancoId" ).val(0);
        $( "#TmpCheques_tipoCheque" ).val(0);
        $( "#TmpCheques_endosante" ).val('');
        // $( "#TmpCheques_tasaDescuento" ).val('<?php echo Yii::app()->user->model->sucursal->tasaDescuentoGeneral ?>');
        // $( "#TmpCheques_tasaDescuento" ).removeAttr("disabled");
        $( "#TmpCheques_clearing" ).val('<?php echo Yii::app()->user->model->sucursal->diasClearing ?>');
        $( "#TmpCheques_clearing" ).removeAttr("disabled");
        //$( "#TmpCheques_pesificacion" ).val('<?php echo Yii::app()->user->model->sucursal->tasaPesificacion ?>');
        $( "#TmpCheques_montoNeto" ).val(0);
        $( "#TmpCheques_tieneNota" ).attr('checked',false);
        $("#libradorId_lookup").val("");
        $("#libradorId_save").val("");
        $("#TmpCheques_fechaPago").focus();
        getDatosCliente();
        $("#montoOrigen_text").val("");

        var tdtabla=$(".formulario").find(".resultado").find(".tablaresultado");
        tdtabla.html("");
    }
    function Unformat(nStr)
    {
        nStr += '';
        x = nStr.split('$ ');
        y = x[1];
        //return y;
        //alert(y);
        y = y.split('.');
        var z='';
        for(var i=0;i<y.length;i++)
            z=z+y[i];
        x = z.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        return x1 + x2;

    }

    function EliminarCheque(url)
    {
        var valor=url.split("/");
        id=valor[valor.length-1];
        $.fn.yiiGridView.update('tmp-cheques-grid', {
            type :'GET',
            url  : url,
            success:function(data,status) {
                $.fn.yiiGridView.update('tmp-cheques-grid');
                var datos=jQuery.parseJSON(data);
                $("#OperacionesCheques_montoNetoTotal").val(datos.montoNetoTotal);
                $("#montoNominalTotal").val(datos.montoNominalTotal);
                $("#totalIntereses").val(datos.totalIntereses);
                 $("#totalPesificacion").val(datos.totalPesificacion);
            }
        });

    }

    function VerificarMascara(obj)
    {
        var valor=$(obj).val().replace( "_", "0");
        valor=valor.replace( "_", "0");
        $(obj).val(valor);
    }

    function getDatosFinanciera(){

        if($("#OperacionesCheques_financieraId").val()!=""){
            $.ajax({
                type: 'POST',
                url: "<?php echo CController::createUrl('clientes/getCliente') ?>",
                data:{'id':$("#OperacionesCheques_clienteId").val()},
                dataType: 'text',
                success:function(data){
                    var datos=jQuery.parseJSON(data);
                    var cliente=datos.cliente;
                    if(cliente.tasaTomador!="")
                        $("#TmpCheques_tasaDescuento").val(cliente.tasaTomador);
                    if(cliente.tasaPesificacionTomador!="")
                        $("#TmpCheques_pesificacion").val(cliente.tasaPesificacionTomador);
                    $("#clienteId").val($("#OperacionesCheques_clienteId").val());
                }
            });
        }
    }

    function esChequeCorriente(){
        var fecOp = new Date($("#OperacionesCheques_fecha").datepicker("getDate"));
        var today = new Date();
        var fecPago = new Date($( "#TmpCheques_fechaPago" ).datepicker("getDate"));
        var fecMargenCorriente = new Date();
        fecMargenCorriente.setDate(fecPago.getDate() - 30);
        if((fecPago > fecMargenCorriente) && (fecPago <= fecOp)) {  
            $("#TmpCheques_tasaDescuento").attr("disabled","disabled");
            $("#TmpCheques_clearing").attr("disabled","disabled");
            $("#TmpCheques_pesificacion").focus();
        } else {
            $("#TmpCheques_tasaDescuento").removeAttr("disabled");
            $("#TmpCheques_clearing").removeAttr("disabled");
            $("#TmpCheques_numeroCheque").focus();
        }
        // alert(date);
        //     $.ajax({
        //         type: 'POST',
        //         url: "<?php echo CController::createUrl('tmpCheques/esChequeCorriente') ?>",
        //         data:{'fechaPago':$( "#TmpCheques_fechaPago" ).val(), 'fechaOperacion': $("#OperacionesCheques_fecha").val()},
        //         dataType: 'text',
        //         success:function(data){
        //             var datos=jQuery.parseJSON(data);
        //             if(datos.esCorriente==true){

        //             } else {

        //             }

        //         }
        //     });
    }

    function esFechaValida(txtDate)
    {
          var currVal = txtDate.val();
          if(currVal == '')
            return false;

          //Declare Regex
          var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
          var dtArray = currVal.match(rxDatePattern); // is format OK?

          if (dtArray == null)
             return false;

          //Checks for mm/dd/yyyy format.
          dtMonth = dtArray[3];
          dtDay= dtArray[1];
          dtYear = dtArray[5];

          if (dtMonth < 1 || dtMonth > 12)
              return false;
          else if (dtDay < 1 || dtDay> 31)
              return false;
          else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
              return false;
          else if (dtMonth == 2)
          {
             var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
             if (dtDay> 29 || (dtDay ==29 && !isleap))
                  return false;
          }
          if(dtMonth<10 && dtMonth.indexOf("0")==-1)
            dtMonth="0"+dtMonth;
        if(dtDay<10 && dtDay.indexOf("0")==-1)
            dtDay="0"+dtDay;
        txtDate.val(dtDay+"/"+dtMonth+"/"+dtYear);
          return true;
    }

</script>

<style>
    .tabla th, td, caption {
        padding: 0px 5px 0px 0px;
    }

    select:focus { border:1px solid black;}
</style>
<?php
if (count($tmpcheque->getErrors()) > 0) {
    $error = $tmpcheque->getErrors();
}
?>


<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'tmp-cheques-cliente-form',
        'enableAjaxValidation' => true,
    ));
?>

<div class="form">
    <p class="note">Campos con <span class="required">*</span> son requeridos.</p>

    <table>
        <tr>
            <td><?php echo CHtml::label("Fecha", 'fecha'); ?></td>
            <td><?php
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
            'value' => $fecha,
            'readonly' => "readonly",
            'style' => 'height:20px;',
            'onChange' => 'js:$("#OperacionesCheques_fecha").focus(); $("#fecha").val($("#OperacionesCheques_fecha").val())',
        )
            )
    );
    ?>
            </td>
            <td>
                <?php echo CHtml::label("Financiera", 'financieraId'); ?></td>
            <td><?php
                $this->widget('CustomEJuiAutoCompleteFkField', array(
                    'model' => $model,
                    'attribute' => 'pkModeloRelacionado', //the FK field (from CJuiInputWidget)
                    // controller method to return the autoComplete data (from CJuiAutoComplete)
                    'sourceUrl' => Yii::app()->createUrl('/financieras/buscarNombre', array("tipo[0]" => Clientes::TYPE_TOMADOR, "tipo[1]" => Clientes::TYPE_TOMADOR_E_INVERSOR)),
                    // defaults to false.  set 'true' to display the FK field with 'readonly' attribute.
                    'showFKField' => false,
                    // display size of the FK field.  only matters if not hidden.  defaults to 10
                    'FKFieldSize' => 15,
                    'relName' => 'financiera', // the relation name defined above
                    'displayAttr' => 'nombre', // attribute or pseudo-attribute to display
                    // length of the AutoComplete/display field, defaults to 50
                    'autoCompleteLength' => 30,
                    // any attributes of CJuiAutoComplete and jQuery JUI AutoComplete widget may
                    // also be defined.  read the code and docs for all options
                    'options' => array(
                        // number of characters that must be typed before
                        // autoCompleter returns a value, defaults to 2
                        'minLength' => 1,
                    ),
                    //'select' => 'getDatosCliente();',
                    'htmlOptions' => array( 'tabindex' => 1),
                    'onSelectScript'=>CHtml::ajax(array('type'=>'POST', 
                                    'url'=>array("operacionesCheques/cargarProductosFinanciera"), 
                                    'update'=>'#OperacionesCheques_productoId')),
                ));
            ?>
            </td>
			<td>
				<?php echo $form->labelEx($model,'productoId'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($model, 'productoId', array(), array('empty' => 'Seleccionar un producto')) ?>				
			</td>
        </tr>
    </table>
</div><!-- form -->

<?php 
if ($model->clienteId) {
	echo "<script>";
	echo CHtml::ajax(array('type'=>'POST', 'url'=>array("operacionesCheques/cargarProductosCliente"), 'data'=>array("OperacionesCheques[clienteId]"=>$model->clienteId), 'update'=>'#OperacionesCheques_productoId'));
	echo "</script>";
}
?>


<?php $this->endWidget(); ?>

<div id="chequestemporales">
    <?php
    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tmp-cheques-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


    $this->beginWidget('zii.widgets.CPortlet', array(
        'title' => '',
    ));
    echo "<b>Cheques de la Operacion</b>";
    $this->endWidget();
    ?>


    <?php //echo var_dump($tmpcheque->getErrors()); ?>
    <?php
    $presupuesto = 0;
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'tmp-cheques-grid',
        'dataProvider' => $tmpcheque->searchByUserName($presupuesto),
        'columns' => array(
            array(
                'name' => 'bancoId',
                'header' => 'Banco',
                'value' => '$data->banco->nombre',
            ),
            'numeroCheque',
            array(
                'name' => 'fechaPago',
                'header' => 'Fecha Vencim.',
                'value' => '$data->fechaPago',
            ),
            array(
                'name' => 'diasAlVenc',
                'header' => 'Dias al Venc.',
                'value' => '$data->diasAlVenc',
            ),
            array(
                'name' => 'libradorId',
                'header' => 'Librador',
                'value' => '$data->librador->denominacion',
            ),
            array(
                'name' => 'montoOrigen',
                'header' => 'Valor Nominal',
                'value' => 'Utilities::MoneyFormat($data->montoOrigen)',
            ),
            array(
                'name' => 'tasaDescuento',
                'header' => 'Gastos por Intereses',
                'value' => 'Utilities::MoneyFormat($data->descuentoTasa)',
            ),
            array(
                'name' => 'pesificacion',
                'header' => 'Gastos por Pesific.',
                'value' => 'Utilities::MoneyFormat($data->descuentoPesific)',
            ),
            array(
                'name' => 'montoNeto',
                'header' => 'Neto',
                'value' => 'Utilities::MoneyFormat($data->montoNeto)',
            ),
            array(
                'class' => 'CButtonColumn',
                'header' => 'Opciones',
                'template' => '{delete}',
                'buttons' => array(
                    'delete' => array(
                        'label' => 'Eliminar',
                        'url' => 'Yii::app()->createUrl("/tmpCheques/deleteCheque", array("id" => $data->id))',
                        'options' => array(// this is the 'html' array but we specify the 'ajax' element
                            'class' => 'cssGridButton',
                        ),
                        'click' => 'js:function() {
				if(confirm("Esta seguro que desea eliminar el cheque seleccionado?"))
					EliminarCheque( $(this).attr("href") ); return false;}'
                )),
            ),
        )
    ));
    ?>

</div>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'tmp-cheques-form',
        'enableAjaxValidation' => true,
            //'action'=>Yii::app()->createUrl("/tmpCheques/addnew"),
            ));
    ?>

    <p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

    <div id="erroresCheque"><?php echo $form->errorSummary($tmpcheque); ?></div>

    <table class="formulario tabla">
        <tr>
            <td><?php echo $form->labelEx($tmpcheque, 'fechaPago'); ?></td>
            <td><?php echo $form->labelEx($tmpcheque, 'clearing'); ?></td>
            <td><?php echo $form->labelEx($tmpcheque, 'pesificacion'); ?></td>
        </tr>
        <tr>
            <td>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    // you must specify name or model/attribute
                    'model' => $tmpcheque,
                    'attribute' => 'fechaPago',
                    'value' => $tmpcheque->fechaPago,
                    'language' => 'es',
                    'options' => array(
                        // how to change the input format? see http://docs.jquery.com/UI/Datepicker/formatDate
                        'dateFormat' => 'dd/mm/yy',
                        'defaultDate' => $tmpcheque->fechaPago,
                        'monthNames' => array('Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Octubre,Noviembre,Diciembre'),
                        'monthNamesShort' => array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"),
                        'dayNames' => array('Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'),
                        'dayNamesMin' => array('Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'),
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                        // shows the button panel under the calendar (buttons like "today" and "done")
                        'showButtonPanel' => 'true',
                        // this is useful to allow only valid chars in the input field, according to dateFormat
                        'constrainInput' => 'false',
                        // speed at which the datepicker appears, time in ms or "slow", "normal" or "fast"
                        'duration' => 'fast',
                        // animation effect, see http://docs.jquery.com/UI/Effects
                        'showAnim' => 'fold',
                    ),
                    // optional: html options will affect the input element, not the datepicker widget itself
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'onChange' => 'js:if(esFechaValida($( "#TmpCheques_fechaPago" ))) esChequeCorriente(); else { alert("Fecha Invalida"); $( "#TmpCheques_fechaPago" ).focus(); }',
                        'tabindex' => 2,
                    )
                ));
                ?>
            </td>
            <td>
                <?php echo $form->textField($tmpcheque, 'clearing', array('size' => 10, 'value' => Yii::app()->user->model->sucursal->diasClearing)); ?>
            </td>
            <td>
                <?php
                $this->widget('CMaskedTextField', array(
                    'model' => $tmpcheque,
                    'attribute' => 'pesificacion',
                    'name' => 'TmpCheques_pesificacion',
                    'mask' => '9.99',
                    'htmlOptions' => array(
                        'onblur' => 'js:VerificarMascara(this);',
                        'style' => 'width:80px;',
                        'value' => Yii::app()->user->model->sucursal->tasaPesificacion,
                    ),
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($tmpcheque, 'numeroCheque'); ?></td>
            <td><?php echo $form->labelEx($tmpcheque, 'libradorId'); ?></td>
            <td colspan="2"><?php echo $form->labelEx($tmpcheque, 'bancoId'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->textField($tmpcheque, 'numeroCheque', array('size' => 20, 'maxlength' => 45, 'tabindex' => 3)); ?></td>
            <td><?php
                $this->widget('EJuiAutoCompleteFkField', array(
                    'model' => $tmpcheque,
                    'attribute' => 'libradorId', //the FK field (from CJuiInputWidget)
                    'sourceUrl' => Yii::app()->createUrl('/libradores/buscarLibradores'),
                    'showFKField' => false,
                    'FKFieldSize' => 15,
                    'relName' => 'librador', // the relation name defined above
                    'displayAttr' => 'denominacion', // attribute or pseudo-attribute to display
                    'autoCompleteLength' => 40,
                    'options' => array(
                        'minLength' => 1,
                    ),
                    'htmlOptions' => array(
                        'tabindex' => 4)
                ));
                ?>

                <?php //echo $form->dropDownList($tmpcheque, 'libradorId', CHtml::listData(Libradores::model()->findAll(), 'id', 'denominacion'), array('prompt' => 'Seleccione un Librador','tabindex'=>4,'class'=>'testClass'));  ?></td>
            <td colspan="2"><?php echo $form->dropDownList($tmpcheque, 'bancoId', CHtml::listData(Bancos::model()->findAll(), 'id', 'nombre'), array('prompt' => 'Seleccione un Banco', 'tabindex' => 5)); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($tmpcheque, 'montoOrigen'); ?></td>
            <td><?php echo $form->labelEx($tmpcheque, 'tipoCheque'); ?></td>
            <td colspan="2"><?php echo $form->labelEx($tmpcheque, 'endosante'); ?></td>

        </tr>
        <tr>
             <td><?php $this->widget("FormatCurrency",
                array(
                    "model" => $tmpcheque,
                    "attribute" => "montoOrigen",
                    "htmlOptions" => array("tabindex"=>6)
                    ));
            ?>
                <?php //echo $form->textField($tmpcheque, 'montoOrigen', array('size' => 20, 'maxlength' => 17, 'tabindex' => 6, "class"=>"currency")); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($tmpcheque, 'tipoCheque', $tmpcheque->getTypeOptions('tipoCheque'), array('prompt' => 'Seleccione un Tipo', 'tabindex' => 7)); ?>
            </td>
            <td colspan="2"><?php echo $form->textField($tmpcheque, 'endosante', array('size' => 35, 'maxlength' => 100, 'tabindex' => 8)); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($tmpcheque, 'tieneNota'); ?>
                <?php echo $form->checkBox($tmpcheque, 'tieneNota') ?>
            </td>
            <td><?php echo $form->labelEx($tmpcheque, 'fisico'); ?>
                <?php echo $form->checkBox($tmpcheque, 'fisico') ?>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($tmpcheque, 'tasaFinanciera'); ?>
                <?php echo $form->textField($tmpcheque, 'tasaFinanciera',  array('size' => 10, 'value' => '0'));   ?>
            </td>
            <td><?php echo $form->labelEx($tmpcheque, 'tipoTasaFinanciera'); ?>
                <?php echo $form->dropDownList($tmpcheque, 'tipoTasaFinanciera', array(), array('empty' => 'Seleccionar un producto')) ?>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr class="resultado">
            <td><?php
                echo CHtml::ajaxButton('Calcular Monto Neto', CHtml::normalizeUrl(array('tmpCheques/calcularMontoNeto', 'render' => false)), array(
                    'type' => 'POST',
                    'data' => array('tasaDescuento' => 'js:$("#TmpCheques_tasaDescuento").val()',
                        'clearing' => 'js:$("#TmpCheques_clearing").val()',
                        'pesificacion' => 'js:$("#TmpCheques_pesificacion").val()',
                        'montoOrigen' => 'js:$("#montoOrigen").val()',
                        'fechaPago' => 'js:$("#TmpCheques_fechaPago").val()',
                        'fechaOperacion' => 'js:$("#OperacionesCheques_fecha").val()',
                    ),
                    'dataType' => 'text',
                    'beforeSend' => 'js:function(){
					if($("#TmpCheques_tasaDescuento").val()=="" || $("#TmpCheques_clearing").val()=="" || $("#montoOrigen").val()=="" || $("#TmpCheques_fechaPago").val()==""){
						alert("Algunos de los valores requeridos para calcular el monto neto no fueron ingresados. Por favor ingreselos");
						return false;
					}

					return true;
				}',
                    'success' => 'js:function(data){
                        var datos = jQuery.parseJSON(data);
                        if(datos.estado!=-1){
        					$("#TmpCheques_montoNeto").val(datos.montoNeto);
        					$("#TmpCheques_descValor").val(datos.descuentoTasa);
        					$("#TmpCheques_pesificValor").val(datos.descuentoPesific);
        					var tdtabla=$(".formulario").find(".resultado").find(".tablaresultado");
        					tdtabla.html("<table border=1 class=\"ui-widget ui-widget-content\"><thead class=\"ui-widget-header \"><tr><th>Monto Neto</th><th>Gastos por Tasa Descuento</th><th>Gastos por Pesificacion</th></tr></thead><tbody><tr><td>"+datos.montoNeto+"<td>"+datos.descuentoTasa+"</td><td>"+datos.descuentoPesific+"</td></tr></tbody></table>");
    					} else
                            alert("El cheque a ingresar ya expiro");
                    }',
                ));
                ?>
            </td>
            <td class='tablaresultado' colspan=3><?php echo $form->error($tmpcheque, 'montoNeto'); ?></td>
        </tr>
    </table>

    <?php
    //echo CHtml::hiddenField('fechaOperacion', '', array("id" => "fechaOperacion"));
    echo $form->hiddenField($tmpcheque, 'montoNeto', array('size' => 20, 'maxlength' => 17, 'readonly' => "readonly"));
    echo $form->hiddenField($tmpcheque, 'presupuesto', array('value' => 0));
    ?>
    <div class="row buttons">
        <?php
        echo CHtml::ajaxSubmitButton(Yii::t('tmpcheques', 'Agregar Cheque'), CHtml::normalizeUrl(array('tmpCheques/create', 'render' => false)), array(
            'data' => 'js:jQuery(this).parents("form").serialize()+"&fechaOperacion="+$("#OperacionesCheques_fecha").val()',
            'beforeSend' => 'js:function(){
					if($("#TmpCheques_tasaDescuento").val()=="" || $("#TmpCheques_clearing").val()=="" || $("#TmpCheques_montoOrigen").val()=="" || $("#TmpCheques_fechaPago").val()==""){
						alert("Algunos de los valores requeridos para calcular el monto neto no fueron ingresados. Por favor ingreselos");
						return false;
					}
                    if(!esFechaValida($("#TmpCheques_fechaPago"))){
                        alert("Fecha Invalida");
                        $("#TmpCheques_fechaPago").focus();
                        return false;
                    }
					return true;
				}',
            'success' => 'js: function(data) {
                            var datos=jQuery.parseJSON(data);
							if(datos.errores!==null)
								$("#erroresCheque").html(datos.errores);
							else{
								$("#erroresCheque").html("");
								LimpiarFormulario();
								$("#OperacionesCheques_montoNetoTotal").val(datos.montoNetoTotal);
                                $("#montoNominalTotal").val(datos.montoNominalTotal);
                                $("#totalIntereses").val(datos.totalIntereses);
                                $("#totalPesificacion").val(datos.totalPesificacion);
								$.fn.yiiGridView.update("tmp-cheques-grid");
							}
						}'),array("tabindex"=>9)
        );
        ?>
        <?php echo CHtml::button("Limpiar formulario",array("onclick"=>"LimpiarFormulario()"));?>
    </div>

    <?php $this->endWidget(); ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'operaciones-cheques-form',
        'enableAjaxValidation' => false,
            ));
    ?>

        <div id="errores"><?php echo $form->errorSummary($model); ?></div>

        <table>
            <tr>
                <td><?php echo Chtml::label("Total Intereses","")?></td>
                <td><?php echo Chtml::label("Total Gastos de Pesificacion","")?></td>
                <td><?php echo $form->labelEx($model, 'montoNetoTotal'); ?></td>
                <td><?php echo Chtml::label("Total Monto Nominal","")?></td>
            </tr>
            <tr>
                <td><?php echo Chtml::textField("totalIntereses",Utilities::MoneyFormat($model->montoIntereses),array("readonly"=>"readonly",'size' => 15,'id'=>'totalIntereses'))?></td>
                <td><?php echo Chtml::textField("totalPesificacion",Utilities::MoneyFormat($model->montoPesificacion),array("readonly"=>"readonly",'size' => 15,'id'=>'totalPesificacion'))?></td>
                <td><?php echo $form->textField($model, 'montoNetoTotal', array('size' => 15, 'maxlength' => 15, 'readonly' => 'readonly','value'=>Utilities::MoneyFormat($model->montoNetoTotal))); ?></td>
                <td><?php echo Chtml::textField("montoNominalTotal",Utilities::MoneyFormat($model->montoNominalTotal),array("readonly"=>"readonly",'size' => 15,'id'=>'montoNominalTotal'))?></td>
            </tr>
        </table>

        <?php echo $form->hiddenField($model, 'fecha', array('id'=>'fecha','value' => date("d-m-Y"))); ?>
        <?php echo $form->hiddenField($model, 'clienteId', array("id"=>"clienteId",'value' => '')); ?>
        <?php echo $form->hiddenField($model, 'productoId', array("id"=>"productoId",'value' => '')); ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Crear Operacion'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->