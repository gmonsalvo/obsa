<style>
    .grid-view table.items tr.tbrow {
        background: none repeat scroll 0 0 #9FF781;
    }
    #grid{
        position:relative;
        overflow: auto;
        height: 400px;
    }
</style>
<?php
	$this->breadcrumbs = array(
    	'Caja' => array('adminCaja'),
	);
?>

<h2><b>Caja</b></h2>

<div class="form">

<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'caja-form',
        'enableAjaxValidation' => false,
    ));
?>

<?php echo $form->errorSummary($model); 
?>

Fecha Desde:
<?php
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    	'name' => 'fechaDesde',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
			'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaDesde',
			'value'=>Date('d/m/Y'),
            'readonly' => "readonly",
            'style' => 'height:20px;'
        )
	));
?>
&nbsp; Fecha Hasta: 
<?php
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => 'fechaHasta',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaHasta',
            'value'=>Date('d/m/Y'),
            'readonly' => "readonly",
            'style' => 'height:20px;'
        )
	));
?>

<?php
    echo CHtml::ajaxButton('Filtrar',
            CHtml::normalizeUrl(array('flujoFondos/filtrar', 'render' => false)), array(
		        'type' => 'GET',
        		'data' => array(
            		'fechaDesde' => 'js:$("#fechaDesde").val()',
            		'fechaHasta' => 'js:$("#fechaHasta").val()',
        		),
       			'dataType' => 'text',
        		'success' => 'js:function(data){
					$("#grid").html(data);
				}',
		));
?>

<div id='grid'>
	<?php
		$dataProvider = $model->searchByDate($model->fechaDesde,$model->fechaHasta);
		$dataProvider->setPagination(false);
		$this->renderPartial('/flujoFondos/_adminCaja', array('flujoFondos' => $model,
			'dataProvider' => $dataProvider,
		));
	?>
</div>
<div id="saldo">
	<?php

	?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->