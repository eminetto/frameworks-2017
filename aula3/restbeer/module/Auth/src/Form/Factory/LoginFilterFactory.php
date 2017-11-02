<?php

namespace Auth\Form\Factory;

use Auth\Form\LoginFilter;
use Interop\Container\ContainerInterface;

class LoginFilterFactory {

    public function __invoke(ContainerInterface $containerInterface) {
        return new LoginFilter($containerInterface);
    }

}
