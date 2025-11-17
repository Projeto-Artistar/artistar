<?php

namespace Source\Model\Helpers;

class PaymentMethods {

    private $methods = [];

    public function __construct() {
        $this->addMethod('dinheiro', 'Dinheiro');
        $this->addMethod('pix', 'Pix');
        $this->addMethod('cartao-debito', 'Cartão de Débito');
        $this->addMethod('cartao-credito', 'Cartão de Crédito');
        $this->addMethod('boleto', 'Boleto');
        $this->addMethod('transferencia', 'Transferência');
        $this->addMethod('outro', 'Outro');
    }

    public function addMethod($alias, $name) {
        $this->methods[$alias] = $name;
    }

    public function getMethods() {
        return $this->methods;
    }

    public function getMethodByKey($key) {
        return $this->getMethods()[$key];
    }

    public function getMethodKeyByName($name) {
        $key = array_search($name, $this->methods);
        return $key !== false ? $key : null;
    }

}