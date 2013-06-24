<div>Cliente: 
    <?php
    $this->widget('EJuiAutoCompleteFkField', array(
        'model' => $model,
        'attribute' => 'clienteId', //the FK field (from CJuiInputWidget)
        // controller method to return the autoComplete data (from CJuiAutoComplete)
        'sourceUrl' => Yii::app()->createUrl('/clientes/buscarRazonSocial', array("tipo[0]" => Clientes::TYPE_INVERSOR, "tipo[1]" => Clientes::TYPE_TOMADOR_E_INVERSOR)),
        // defaults to false.  set 'true' to display the FK field with 'readonly' attribute.
        'showFKField' => false,
        // display size of the FK field.  only matters if not hidden.  defaults to 10
        'FKFieldSize' => 15,
        'relName' => 'cliente', // the relation name defined above
        'displayAttr' => 'razonSocial', // attribute or pseudo-attribute to display
        // length of the AutoComplete/display field, defaults to 50
        'autoCompleteLength' => 40,
//            'javascript' => "alert('holaaa');",
        // any attributes of CJuiAutoComplete and jQuery JUI AutoComplete widget may 
        // also be defined.  read the code and docs for all options
        'options' => array(
            // number of characters that must be typed before 
            // autoCompleter returns a value, defaults to 2
            'minLength' => 1,
        ),
    ));
    ?>
</div>
<br>
<?php
echo CHtml::ajaxButton('Informe',
        //Yii::app()->createUrl("cheques/filtrar", array("prueba"=>'$("#fechaIni").val()',)),
        CHtml::normalizeUrl(array('ctacteClientes/obtenerInforme', 'render' => false)), array(
    'type' => 'GET',
    'data' => array(
        'clienteId' => 'js:$("#CtacteClientes_clienteId").val()'
    ),
    'dataType' => 'text',
    'success' => 'js:function(data){
					$("#result").html(data);
					}',
))
?>
<br>
<div id="result"></div>
