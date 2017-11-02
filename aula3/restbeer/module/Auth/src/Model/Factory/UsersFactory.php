<?php

namespace Auth\Model\Factory;

use Auth\Model\Users;
use Interop\Container\ContainerInterface;

class UsersFactory {

    public function __invoke(ContainerInterface $containerInterface) {
        return new Users();
    }

}
