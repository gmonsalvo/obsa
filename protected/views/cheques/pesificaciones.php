<?php
$this->breadcrumbs=array(
	'Cheques'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Cheques', 'url'=>array('index')),
	array('label'=>'Create Cheques', 'url'=>array('create')),
);
?>

<h1>Manage Cheques</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
Fecha inicio: <?php echo CHtml::textField('fechaIni', '2010-02-02', array("id"=>"fechaIni")); ?>
<br>
Fecha inicio: <?php echo CHtml::textField('fechaFin', '2010-12-02', array("id"=>"fechaFin")); ?>
<?php echo CHtml::ajaxButton('Filtrar', 
			//Yii::app()->createUrl("cheques/filtrar", array("prueba"=>'$("#fechaIni").val()',)),
			CHtml::normalizeUrl(array('cheques/filtrar','render'=>false)),
			array(
			    'type'=>'GET',
				'data'=>array(
				'fechaIni'=>'js:$("#fechaIni").val()',
				'fechaFin'=>'js:$("#fechaFin").val()',
				),
				'dataType'=>'text',
				'success' => 'js:function(data){
					$("#grid").html(data);
					}',
				))?>


<div id='grid'><?php 	$this->renderPartial('grid',array('model'=>$model,
			'dataProvider'=>$model->search(),
		));
		?>
</div>		