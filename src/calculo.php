<?php
namespace gamboamartin\calculo;
use DateTime;
use gamboamartin\errores\errores;
use gamboamartin\validacion\validacion;
use JetBrains\PhpStorm\Pure;
use stdClass;
use Throwable;


class calculo{ //DEBUG INI
    private array $meses_espaniol;
    public validacion $validaciones;
    public errores $error;

    /**
     * DEBUG INI
     * calculo constructor.
     */
    #[Pure] public function __construct(){ //PRUEBAS FINALIZADAS
        $this->error = new errores();
        $this->validaciones = new validacion();
        $this->meses_espaniol = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre',
            'octubre','noviembre','diciembre');


    }

    /**
     * DEBUG INI FIN ERROR DEF Funcion el tiempo actual en microsegundos
     *
     *
     * @example
     *      $tiempo_inicio = $calculo_main->microtime_float();
     *
     * @return int tiempo
     * @uses index
     */
    public function microtime_float():int{ //FIN PROT
        
        return time();
    }

    /**
     * PHPUNIT
     * Funcion para obtener el mes en espaniol
     *
     * @param string $fecha
     *
     * @example
     *      $mes_letra = $calculo->obten_mes_espaniol(date('Y-m-d'));
     *
     * @return string|array mes en espaniol
     * @internal $this->validaciones->valida_fecha($fecha);
     * @internal $this->obten_numero_mes($fecha);
     * @uses formatos_valuador
     * @uses controlador_cliente
     */
    public function obten_mes_espaniol(string $fecha):string|array{
        $valida_fecha = $this->validaciones->valida_fecha($fecha);
        if(errores::$error){
            return $this->error->error('Error al validar fecha', $valida_fecha);
        }
        $numero_mes = $this->obten_numero_mes($fecha);
        if(errores::$error){
            return $this->error->error('Error al obtener mes', $numero_mes);
        }
        return $this->meses_espaniol[$numero_mes-1];
    }

    /**
     * PHPUNIT
     * Funcion para obtener el numero de un mes
     *
     * @param string $fecha
     *
     * @example
     *      $numero_mes = $this->obten_numero_mes($fecha);
     *
     * @return string|array numero mes entero
     * @internal $this->validaciones->valida_fecha($fecha);
     * @uses calculo
     */
    private function obten_numero_mes(string $fecha):string|array{
        $valida_fecha = $this->validaciones->valida_fecha($fecha);
        if(errores::$error){
            return $this->error->error('Error al validar fecha', $valida_fecha);
        }
        return intval((date("m", strtotime($fecha))));
    }

    /**
     * PHPUNIT
     * @param int $n_dias
     * @param string $fecha
     * @return string|array
     */
    public function obten_fecha_resta(int $n_dias, string $fecha):string|array{
        $valida = $this->validaciones->valida_fecha($fecha);
        if(errores::$error){
            return $this->error->error('Error al validar fecha', $valida);
        }
        if($n_dias<0){
            return $this->error->error('Error $n_dias debe ser mayor o igual a 0', $n_dias);
        }
        return date("Y-m-d",strtotime($fecha."- $n_dias days"));
    }

    /**
     * PHPUNIT
     * @param string $fecha_inicio
     * @param string $fecha_fin
     * @return int|array
     */
    public function n_dias_entre_fechas(string $fecha_inicio, string $fecha_fin): int|array
    {
        $valida = $this->validaciones->valida_fecha($fecha_inicio);
        if(errores::$error){
            return $this->error->error('$fecha_inicio invalida '.$fecha_inicio, $valida);
        }
        $valida = $this->validaciones->valida_fecha($fecha_fin);
        if(errores::$error){
            return $this->error->error('$fecha_fin invalida '.$fecha_fin, $valida);
        }
        try {
            $fecha_inicio_date = new DateTime($fecha_inicio);
            $fecha_fin_base = new DateTime($fecha_fin);
            $diff = $fecha_inicio_date->diff($fecha_fin_base);
        }
        catch (Throwable $e){
            $data = new stdClass();
            $data->parametros = new stdClass();
            $data->e = $e;
            $data->parametros->fecha_inicio = $fecha_inicio;
            $data->parametros->fecha_fin = $fecha_fin;
            return $this->error->error("Error al calcular diferencia de fechas", $data);
        }
        return (int)$diff->days + 1;
    }


}