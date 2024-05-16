<?php
require_once('class.database.php');

class importe
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function calcular()
    {

        // Obtener los datos del formulario
        $precio_inmueble = $_GET['precI'];
        $dinero_disponible = $_GET['mon'];
        $porcentaje_interes = $_GET['int']; // Convertir el porcentaje a un número decimal
        $plazo_anos = $_GET['anos'];

        // Calcular el monto del préstamo
        $monto_prestamo = $precio_inmueble - $dinero_disponible;

        // Calcular el interés anual
        $interes_anual = $monto_prestamo * $porcentaje_interes;

        // Calcular el pago mensual
        $cuota_mensual = ($monto_prestamo * $interes_anual) / (1 - pow(1 + $interes_anual, -$plazo_anos * 12));

        // Mostrar el resultado
        echo "El pago mensual de la hipoteca es de: " . $cuota_mensual;
    }
}
