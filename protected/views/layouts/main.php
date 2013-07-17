<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">

            <?php if (isset(Yii::app()->user->model)): ?>
                <div id="mainMBMenu">
                    <?php
                    $this->widget('application.extensions.mbmenu.MbMenu', array(
//                    $this->widget('application.extensions.YiiSmartMenu', array(
                        'items' => array(
                            array('label' => 'Configuracion', 'url' => array(''),
//                                'authItemName'=>'usuarioy',
                                'items' => array(
//                                    array('label' => 'Sucursales', 'url' => array('/sucursales/admin'), 'authItemName'=>'administrador'),
//                                    array('label' => 'Productos', 'url' => array('/productos/admin'),'authItemName'=>'usuario'),
                                    array('label' => 'Sucursales', 'url' => array('/sucursales/admin')),
                                    array('label' => 'Productos', 'url' => array('/productos/admin')),
                                    array('label' => 'Monedas', 'url' => array('/monedas/admin')),
                                    array('label' => 'Operadores', 'url' => array('/operadores/admin')),
                                    array('label' => 'Libradores', 'url' => array('/libradores/admin')),
                                    array('label' => 'Pesificadores', 'url' => array('/pesificadores/admin')),
                                    array('label' => 'Bancos', 'url' => array('/bancos/admin')),
                                    array('label' => 'Actividades', 'url' => array('/actividades/admin')),
                                    array('label' => 'Perfiles', 'url' => array('/perfiles/admin')),
                                    array('label' => 'Usuarios', 'url' => array('/user/admin')),
                                    array('label' => 'Flujo de Fondos', 'url' => array('/flujoFondos/admin')),
                                    array('label' => 'Localidades', 'url' => array('/localidades/admin')),
                                    array('label' => 'Provincias', 'url' => array('/provincias/admin')),
                                    array('label' => 'Cuentas', 'url' => array('/cuentas/admin')),
                                    array('label' => 'Conceptos', 'url' => array('/conceptos/admin')),
                                    array('label' => 'Financieras', 'url' => array('/financieras/admin')),
                                ),
                            ),
                            array('label' => 'Clientes', 'url' => array(''),
                                'items' => array(
                                    array('label' => 'Adm. Clientes', 'url' => array('/clientes/admin')),
                                    array('label' => 'Ingreso de Fondos', 'url' => array('/ordenIngreso/create')),
                                    array('label' => 'Retiro de Fondos', 'url' => array('/ordenesPago/retirarFondos')),
                                    array('label' => 'Cuentas Corrientes Clientes', 'url' => array('/ctacteClientes/admin')),
                                    array('label' => 'Informe Posicion', 'url' => array('/clientes/informePosicion')),

                                ),
                            ),
                            array('label' => 'Operatoria Cheques', 'url' => array(''),
                                'items' => array(
                                    array('label' => 'Compra de cheques corrientes y a fecha.', 'url' => array('/operacionesCheques/nuevaOperacion')),
                                    array('label' => 'Listado de Operaciones de Compra', 'url' => array('/operacionesCheques/admin')),
                                    array('label' => 'Presupuestos', 'url' => array('/presupuestoOperacionesCheques/admin')),
                                    array('label' => 'Colocaciones de Cheques', 'url' => array('/colocaciones/create')),
                                    array('label' => 'Reemplazo de Cheques', 'url' => array('/colocaciones/recolocacion')),
                                    array('label' => 'Pesificaciones', 'url' => array('/pesificaciones/admin')),
                                    array('label' => 'Listado de Cheques', 'url' => array('/cheques/adminCheques')),
                                    array('label' => 'Comisiones', 'url' => array('/comisionesOperadores/admin')),

                                ),
                            ),
                            array('label' => 'Operatoria de Cambio', 'url' => array(''),
                                'items' => array(
                                    array('label' => 'Compra/Venta', 'url' => array('/operacionesCambio/create')),
                                ),
                            ),
                            array('label' => 'Proveedores', 'url' => array(''),
                                'items' => array(
                                    array('label' => 'Adm. Proveedores', 'url' => array('/proveedores/admin')),
                                    array('label' => 'Nuevo Movimiento Proveedores', 'url' => array('/ctacteProveedores/create')),
                                    array('label' => 'CtaCte Proveedores', 'url' => array('/ctacteProveedores/admin')),
                                    array('label' => 'Ordenes de Pago', 'url' => array('/ordenesPagoProveedores/create')),
                                ),
                            ),
                            array('label' => 'Tesoreria', 'url' => array(''),
                                'items' => array(
                                    array('label' => 'Mayores de Cuentas', 'url' => array('/flujoFondos/admin')),
                                    array('label' => 'Arqueo Caja Operaciones', 'url' => array('/flujoFondos/cierreCaja')),
                                    array('label' => 'Ordenes de Ingresos', 'url' => array('/ordenIngreso/admin')),
                                    array('label' => 'Ordenes de Pago Clientes', 'url' => array('/ordenesPago/admin')),
                                    array('label' => 'Ordenes de Cambio', 'url' => array('/ordenesCambio/admin')),
                                    array('label' => 'Ordenes de Pago Proveedores', 'url' => array('/ordenesPagoProveedores/admin')),
                                    array('label' => 'Movimientos de Cuentas', 'url' => array('/flujoFondos/movimientoCuentas')),

                                ),
                            ),
                            array('label' => 'Reportes', 'url' => array(''),
                                'items' => array(
                                    array('label' => 'Clientes Saldo Negativo', 'url' => array('/ctacteClientes/informeCtacte')),
                                    array('label' => 'Ranking de Libradores', 'url' => array('/libradores/ranking')),
                                    array('label' => 'Ranking de Clientes', 'url' => array('/clientes/ranking')),
                                    array('label' => 'Ranking de Endosantes', 'url' => array('/clientes/ranking')),
                                ),
                            ),
                        ),
                    ));
                    ?>
                </div><!-- mainmenu -->
                <?php endif ?>
                <?php if (isset(Yii::app()->user->model)): ?>
                <div align="right">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => '',
                ));
                echo "<b>Usuario Actual:</b> " . Yii::app()->user->model->username . " | ";
                echo "<b>Sucursal:</b> " . Yii::app()->user->model->sucursal->nombre . " | ";
                echo CHtml::link('Cerrar Sesion', array('site/logout'));
                $this->endWidget();
                ?>
                </div>
                <?php endif ?>
                <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php $this->widget('Flashes'); ?>

            <?php echo $content; ?>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> by ARLAB TI - Dev Division.<br/>
                Todos los Derechos reservados.<br/>
                <?php echo Yii::powered(); ?>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
