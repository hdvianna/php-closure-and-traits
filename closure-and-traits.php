<?php

trait myTraitOne {
    public function behaviorOne() {
        echo "Behavior from myTraitOne".PHP_EOL;
        parent::top();
        echo ClosureAndTraitsClass::CONST_1.PHP_EOL;
        $this->privateMethod();
    }
}

trait myTraitTwo {
    public function behaviorTwo() {
        echo "Behavior from myTraitTwo".PHP_EOL;
        echo static::$static.PHP_EOL;
        echo self::CONST_2.PHP_EOL;
        $this->behaviorOne();
    }
}

$myClosureOne = function() {    
    echo "Behavior from myClosureOne".PHP_EOL;
    parent::top();
    echo ClosureAndTraitsClass::CONST_1.PHP_EOL;
    $this->privateMethod();
};

$myClosureTwo = function() {
    echo "Behavior from myClosureTwo".PHP_EOL;
    echo static::$static.PHP_EOL;  
    echo self::CONST_2.PHP_EOL;  
    $this->behaviorOne();
};

class Base {
    protected function top() {
        echo "Top method".PHP_EOL;
    }
} 

class ClosureAndTraitsClass extends Base {
    use myTraitOne, myTraitTwo;
    
    const CONST_1 = 'CONST_1', CONST_2 = 'CONST_2';

    static private $static = "Static prop!";

    private function privateMethod() {
        echo "privateMethod".PHP_EOL;
    }
}

/**
 * De maneira geral, traits habilitam a criação de herança múltipla no PHP.
 * Problemas do diamente são solucionados pela clausula 'insteadof' que indica qual
 * trait deve ser utilizada em caso de conflito, por exemplo:
 * 
 *trait A {
 *   public function smallTalk() {
 *       echo 'a';
 *   }
 *   public function bigTalk() {
 *       echo 'A';
 *   }
 *}
 *
 *trait B {
 *    public function smallTalk() {
 *        echo 'b';
 *    }
 *    public function bigTalk() {
 *        echo 'B';
 *    }
 *}
 *
 *class Talker {
 *    use A, B {
 *        B::smallTalk insteadof A;
 *        A::bigTalk insteadof B;
 *    }
 *}
 * 
 * Além disso, Traits sobrescrevem os métodos da classe pai, e são sobrescritos pela classe final, 
 * por exemplo:
 * 
 *class Base {
 *    public function sayHello() {
 *        echo 'Hello ';
 *    }
 *}
 *
 *trait SayWorld {
 *    public function sayHello() {
 *        parent::sayHello();
 *        echo 'World!';
 *    }
 *}
 *
 *class MyHelloWorld extends Base {
 *    use SayWorld;
 *}
 * 
 * 
 * Por fim, diferente de classes e interfaces, traits não permitem a herança.
 * 
 * O uso traits pode ser simulado com o uso de closures. Inclusive é possível utilizar 
 * as keywords self, parent and static para acessar métodos e propriedades definidas na classe
 * 
 */

$myClosureAndTraitsObject = new ClosureAndTraitsClass();
echo "------------------------".PHP_EOL;
$myClosureAndTraitsObject->behaviorOne();
echo "------------------------".PHP_EOL;
$myClosureAndTraitsObject->behaviorTwo();
echo "------------------------".PHP_EOL;
$myClosureOne->call($myClosureAndTraitsObject);
echo "------------------------".PHP_EOL;
$myClosureTwo->call($myClosureAndTraitsObject);