<script>
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

<div class="wide form">

<?php



$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
?>

  
<div class="row">
	<?php echo $form->label($model,'Financiera'); 

	$this->widget('EJuiAutoCompleteFkField', array(
          'model'=>$model, 
          'attribute'=>'pkModeloRelacionado', //the FK field (from CJuiInputWidget)
          // controller method to return the autoComplete data (from CJuiAutoComplete)
          'sourceUrl'=>Yii::app()->createUrl('/financieras/buscarNombre'), 
          // defaults to false.  set 'true' to display the FK field with 'readonly' attribute.
          'showFKField'=>true,
           // display size of the FK field.  only matters if not hidden.  defaults to 10
          'FKFieldSize'=>15, 
          'relName'=>'pkModeloRelacionado', // the relation name defined above
          'displayAttr'=>'nombre',  // attribute or pseudo-attribute to display
          // length of the AutoComplete/display field, defaults to 50
          'autoCompleteLength'=>40,
          // any attributes of CJuiAutoComplete and jQuery JUI AutoComplete widget may 
          // also be defined.  read the code and docs for all options
          'options'=>array(
              // number of characters that must be typed before 
              // autoCompleter returns a value, defaults to 2
              'minLength'=>1, 
          ),
          'onSelectScript'=>CHtml::ajax(array('type'=>'POST', 'url'=>array("ctacte/cargarProductosCliente"), 'update'=>'#Ctacte_productoId')),
     ));
     ?>
</div>
<div class="row">
		<?php echo $form->label($model,'productoId'); ?>
		<?php echo $form->dropDownList($model, 'productoId', array(), array('empty' => 'Seleccionar un producto')) ?>
<?php /*echo CHtml::activeDropDownList($model,'productoId',
		CHtml::listData(Productos::model()->findAll(), 
		'id', 'nombre'),array('empty'=>'Seleccione un Producto'));*/
	?>
</div>
<div class="row">
	<?php echo $form->label($model,'Fecha Inicio'); ?>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaInicio',
         'model' => $model,
        'attribute' => 'fechaInicio',
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
            'id' => 'fechaInicio',
            'value' => '01/02/2013',
            'onChange' => 'js:if(esFechaValida($("#fechaInicio" ))); else { alert("Fecha Invalida"); $( "#fechaInicio" ).focus(); }',
            'style' => 'height:20px;'
        )
            )
    );
    ?>
</div>	

<div class="row">
<?php echo $form->label($model,'Fecha Fin'); ?>
    <?php
    $fechaFin=Date('d/m/Y');
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaFin',
        'model' => $model,
        'attribute' => 'fechaFin',
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
            'style' => 'height:20px;',
            'onChange' => 'js:if(esFechaValida($("#fechaFin" ))); else { alert("Fecha Invalida"); $( "#fechaFin" ).focus(); }',
            'value' => $fechaFin
        )
            )
    );
    ?>
 </div>	
<div class="row buttons">
		<?php echo CHtml::submitButton('Filtrar'); ?>
	</div>

<?php $this->endWidget(); 
?>

</div><!-- search-form -->