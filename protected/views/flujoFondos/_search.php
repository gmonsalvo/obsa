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

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
?>
<table>
<tr>    
<td class="row">
		<?php echo $form->label($model,'cuentaId'); ?>
<?php echo CHtml::activeDropDownList($model,'cuentaId',
		CHtml::listData(Cuentas::model()->findAll(), 
		'id', 'nombre'),array('empty'=>'Seleccione una Cuenta'));
	?>
</td>
<td class="row">
	<?php echo $form->label($model,'Fecha Desde'); ?>
      <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaDesde',
         'model' => $model,
        'attribute' => 'fechaDesde',
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
            'id' => 'fechaDesde',
            'value' => '01/02/2013',
            'onChange' => 'js:if(esFechaValida($("#fechaDesde" ))); else { alert("Fecha Invalida"); $( "#fechaDesde" ).focus(); }',
            'style' => 'height:20px;'
        )
            )
    );
    ?>
</td>	

<td class="row">
<?php echo $form->label($model,'Fecha Fin'); ?>
   <?php
    $fechaHasta=Date('d/m/Y');
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaHasta',
        'model' => $model,
        'attribute' => 'fechaHasta',
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
            'id' => 'fechaHasta',
            'style' => 'height:20px;',
            'onChange' => 'js:if(esFechaValida($("#fechaHasta" ))); else { alert("Fecha Invalida"); $( "#fechaHasta" ).focus(); }',
            'value' => $fechaHasta
        )
            )
    );
    ?>
 </td>	
<td class="row">
		<?php echo CHtml::submitButton('Filtrar'); ?>
</td>
<tr></table>
<?php $this->endWidget(); 
?>

</div><!-- search-form -->