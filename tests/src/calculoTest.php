<?php
namespace tests\src;

use gamboamartin\calculo\calculo;
use gamboamartin\errores\errores;
use tests\test;


class calculoTest extends test {
    public errores $errores;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->errores = new errores();
    }

    public function test_obten_mes_espaniol(){
        errores::$error = false;
        $calculo = new calculo();
        $resultado = $calculo->obten_mes_espaniol('');
        $this->assertIsArray( $resultado);
        $this->assertStringContainsStringIgnoringCase('Error al validar fecha', $resultado['mensaje']);
        $this->assertTrue(errores::$error);

        errores::$error = false;
        $resultado = $calculo->obten_mes_espaniol('2019-01-01');
        $this->assertIsString( $resultado);
        $this->assertStringContainsStringIgnoringCase('enero', $resultado);
        $this->assertNotTrue(errores::$error);
        errores::$error = false;
    }


}