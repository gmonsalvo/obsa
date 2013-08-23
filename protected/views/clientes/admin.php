<?php
$this->breadcrumbs=array(
	'Clientes'=>array('admin'),
	'Administrar',
);

$this->menu=array
(
	//array('label'=>'Listar Clientes', 'url'=>array('index')),
	array('label'=>'Nuevo Cliente', 'url'=>array('create')),

);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('clientes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Clientes</h1>

<!--
<p>
Ademas puede ingresar un operador de comparacion (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
o <b>=</b>) al comienzo de cada parametro de busqueda.
</p>
-->

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<script>
function exportar(){
    window.open("/clientes/exportarLista");
}
</script>
<br /><br />
<?php echo CHtml::button("Exportar PDF",array("onclick"=>"exportar()"));?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clientes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name'=>'razonSocial',
			'header'=>'Razon Social',
			 'type'=>'raw',
             'value'=>'( strlen($data->razonSocial) > 15
                ? CHtml::tag("span", array("title"=>$data->razonSocial), CHtml::encode(substr($data->razonSocial, 0, 15)) . "..")
                : CHtml::encode($data->razonSocial)
            );',
		),
		'fijo',
		'celular',
		array(
			'name'=>'direccion',
			'header'=>'Direccion',
			 'type'=>'raw',
             'value'=>'( strlen($data->direccion) > 10
                ? CHtml::tag("span", array("title"=>$data->direccion), CHtml::encode(substr($data->direccion, 0, 10)) . "..")
                : CHtml::encode($data->direccion)
            );',
		),
		'email',
		'documento',
		'tasaInversor',
		array(
			'name'=>'tipoCliente',
			'header'=>'Tipo Cliente',
			 'type'=>'raw',
             'value'=>'(strlen($data->tipoCliente) > 10
                ? CHtml::tag("span", array("title"=>$data->tipoCliente), CHtml::encode(substr($data->tipoCliente, 0, 10)) . "..")
                : CHtml::encode($data->tipoCliente)
            );',
		),
		array(
			'name'=>'operadorId',
			'header'=>'Operador',
			'type'=>'raw',
             'value'=>'(strlen($data->operador->apynom) > 10
                ? CHtml::tag("span", array("title"=>$data->operador->apynom), CHtml::encode(substr($data->operador->apynom, 0, 10)) . "..")
                : CHtml::encode($data->operador->apynom)
            );',
		),
		array(
			'header'=>'Productos',
			'name'=>'productosBusqueda',
			'type'=>'raw',
			'value'=>array($this, 'dibujarCeldaProductosGrilla'),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
