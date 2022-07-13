<?php

use App\Engine\Simple;

class SimpleEngineForTest extends Simple
{
    /**
     * @param string $methodName
     * @return ReflectionMethod
     */
    public static function exposedMethod(string $methodName, ...$parameters): mixed
    {
        $object = new Simple();
        $reflexion = new ReflectionClass($object);

        $method = $reflexion->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public static function sumExposed(float $a, float $b) : float
    {
        return static::exposedMethod('sum', $a, $b);
    }

    public static function moduloExposed(float $a, float $b) : float
    {
        return static::exposedMethod('modulo', $a, $b);
    }
}

class SimpleTest extends \PHPUnit\Framework\TestCase
{
    public function testMultiply()
    {
        $tests = [
            [1, 1, 1.0],
            [0, 1, 0.0],
            [0, 0, 0.0],
            [9.3, 2, 18.6],
            [-9.3, 2, -18.6],
            [-9.3, -2, 18.6],
            [1.2, 200.3, 240.36]
        ];

        foreach ($tests as $test) {
            list($a, $b, $expected) = $test;
            $result = Simple::multiply($a, $b);
            $this->assertSame($expected, $result, 'Multiplication de ' . $a . ' par ' . $b);
        }
    }

    public function testMultiplyInvalidTypeString()
    {
        $this->expectException(TypeError::class);
        Simple::multiply(3, 'Bonjour');
    }

    public function testMultiplyInvalidTypeObject()
    {
        $object = new stdClass();
        $this->expectException(TypeError::class);
        Simple::multiply($object, 12);
    }

    public function testSum()
    {
        $tests = [
            [1, 1, 2.0],
            [0, 1, 1.0],
            [0, 0, 0.0],
            [9.3, 2, 11.3],
            [-9.3, 2, -7.3],
            [-9.3, -2, -11.3],
            [1.2, 200.3, 201.5]
        ];

        foreach ($tests as $test) {
            list($a, $b, $expected) = $test;
            $result = SimpleEngineForTest::sumExposed($a, $b);
            $this->assertSame($expected, $result, 'Somme de ' . $a . ' par ' . $b);
        }
    }

    public function testSumInvalidTypeString()
    {
        $this->expectException(TypeError::class);
        SimpleEngineForTest::sumExposed(3, 'Bonjour');
    }

    public function testSumInvalidTypeObject()
    {
        $object = new stdClass();
        $this->expectException(TypeError::class);
        SimpleEngineForTest::sumExposed($object, 12);
    }

    public function testModulo()
    {
        $tests = [
            [1, 2, 1.0],
        ];

        foreach ($tests as $test) {
            list($a, $b, $expected) = $test;
            $result = SimpleEngineForTest::moduloExposed($a, $b);
            $this->assertSame($expected, $result, 'Reste de la division de ' . $a . ' par ' . $b);
        }
    }

}