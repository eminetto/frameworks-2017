<?php

namespace Auth\Controller\Factory;

use Auth\Controller\LoginController;
use Interop\Container\ContainerInterface;

class LoginControllerFactory {

    public function __invoke(ContainerInterface $containerInterface) {
        return new LoginController($containerInterface);
    }

}
