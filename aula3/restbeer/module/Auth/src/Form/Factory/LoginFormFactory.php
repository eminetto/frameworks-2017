<?php

namespace Auth\Form\Factory;

use Auth\Form\LoginForm;
use Interop\Container\ContainerInterface;

class LoginFormFactory {

    public function __invoke(ContainerInterface $containerInterface) {
        return new LoginForm($containerInterface);
    }

}
