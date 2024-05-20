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
        $plazo_anos = $_GET['anos'];

        // Validar los valores de entrada
        if ($precio_inmueble <= 0 || $dinero_disponible < 0 || $plazo_anos <= 0) {
            echo "Error: Los valores de entrada no son válidos.";
            return;
        }

        // Calcular el monto del préstamo
        $monto_prestamo = $precio_inmueble - $dinero_disponible;

        // Calcular la tasa de interés mensual
        $interes_mensual = (25 / 100) / 12;

        // Calcular el plazo en meses
        $plazo_meses = $plazo_anos * 12;

        // Calcular el pago mensual
        $divisor = pow(1 + $interes_mensual, $plazo_meses) - 1;
        if ($divisor == 0) {
            echo "Error: No se puede calcular el pago mensual debido a un valor de interés o plazo inválido.";
        } else {
            $cuota_mensual = ($monto_prestamo * $interes_mensual) / $divisor;
            $cuota_mensual_redondeada = round($cuota_mensual, 2);
            echo "El pago mensual de la hipoteca es de: " . $cuota_mensual_redondeada . "€";
        }
    }
}
