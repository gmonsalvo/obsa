<!-- Pagina en uso para Egreso de Fondos (Julio Diaz) -->
<?php
$this->breadcrumbs=array(
	'Cheques'=>array('adminCheques'),
	//$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listado de Cheques', 'url'=>array('adminCheques')),
);
?>

<h2><b>Entrega de Cheque</b></h2>
<?php
	echo $this->renderPartial('viewCheck', array('model'=>$model));
	if ($model->estado == 2)
	{
		echo "<br><b>EL CHEQUE YA FUE ENTREGADO.</b>";
	}
	else
	{
		echo $this->renderPartial('_formUpdateEntrega', array('model'=>$model));
	}
?>