<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS traer_compras_por_mes");
        DB::unprepared("DROP PROCEDURE IF EXISTS traer_ventas_por_mes");
        DB::unprepared("DROP PROCEDURE IF EXISTS traer_vendedores");
        DB::unprepared("DROP PROCEDURE IF EXISTS trer_productos_mas_vendidos");

        DB::unprepared("
        CREATE PROCEDURE `traer_ventas_por_mes`(
            IN `pa_anio` INT
        )
        BEGIN

        SELECT 'Enero' AS 'Mes', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS Total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 01 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Febrero', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 02 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Marzo', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 03 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Abril', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 04 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Mayo', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 05 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Junio', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 06 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Julio', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 07 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Agosto', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 08 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Septiembre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 09 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Octubre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 10 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Noviembre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 11 AND year(ventas.fecha_factura) = pa_anio

        UNION

        SELECT 'Diciembre', if(SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) IS NULL, 0,SUM(detalle_ventas.cantidad_detalle_venta*detalle_ventas.precio_venta) ) AS total
        FROM detalle_ventas
        INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
        WHERE month(ventas.fecha_factura) = 12 AND year(ventas.fecha_factura) = pa_anio ;



        END
        ");

        DB::unprepared("
        CREATE PROCEDURE `traer_compras_por_mes`(
            IN `pa_anio` INT
        )
        BEGIN

        SELECT 'Enero' AS 'Mes', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS Total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 01 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Febrero', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 02 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Marzo', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 03 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Abril', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 04 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Mayo', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 05 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Junio', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 06 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Julio', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 07 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Agosto', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 08 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Septiembre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 09 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Octubre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 10 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Noviembre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 11 AND year(compras.fecha_compra) = pa_anio

        UNION

        SELECT 'Diciembre', if(SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) IS NULL, 0,SUM(detalle_compras.cantidad_detalle_compra*detalle_compras.precio) ) AS total
        FROM detalle_compras
        INNER JOIN compras ON compras.id = detalle_compras.compra_id
        WHERE month(compras.fecha_compra) = 12 AND year(compras.fecha_compra) = pa_anio;


        END
        ");


        DB::unprepared("
        CREATE PROCEDURE `traer_vendedores`(
            IN `pa_anio` INT,
            IN `pa_mes` INT
        )
        BEGIN
            SELECT users.name, sum(detalle_ventas.precio_venta * detalle_ventas.cantidad_detalle_venta) AS total
            FROM detalle_ventas
            INNER JOIN ventas ON ventas.id = detalle_ventas.venta_id
            INNER JOIN users ON users.id = ventas.user_id
            WHERE YEAR(ventas.fecha_factura) = pa_anio AND MONTH(ventas.fecha_factura) = pa_mes
            GROUP BY users.name;
        END
        ");

        DB::unprepared("
        CREATE PROCEDURE `trer_productos_mas_vendidos`()
        BEGIN
                SELECT SUM(detalle_ventas.cantidad_detalle_venta) AS 'vendidos',
                    productos.id,
                    productos.codigo,
                    productos.marca,
                    productos.modelo,
                    productos.descripcion,
                    productos.existencia,
                    productos.prec_venta_fin,
                    productos.imagen_producto,
                    categorias.name AS 'categoria'
                FROM detalle_ventas
                INNER JOIN productos ON productos.id = detalle_ventas.producto_id
                INNER JOIN categorias ON categorias.id = productos.id_categoria
                GROUP BY productos.id,
                        productos.codigo,
                        productos.marca,
                        productos.modelo,
                        productos.descripcion,
                        productos.existencia,
                        productos.prec_venta_fin,
                        productos.imagen_producto,
                        categorias.name
                ORDER BY SUM(detalle_ventas.cantidad_detalle_venta) DESC
                LIMIT 10;
        END
        ");





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
