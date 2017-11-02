<?php

namespace Auth\Model;

use Zend\Hydrator\ClassMethods;

class Users {

    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $created;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created) {
        $this->created = $created;
    }

    public function exchangeArray(array $options = []) {
        $hidrator = new ClassMethods();
        $hidrator->hydrate($options, $this);
    }

    public function toArray() {
        $hidrator = new ClassMethods();
        return $hidrator->extract($this);
    }

}
