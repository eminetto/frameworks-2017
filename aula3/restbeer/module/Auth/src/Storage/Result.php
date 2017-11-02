<?php

namespace Auth\Storage;

class Result {

    protected $message;

    const SUCCESS = 1;
    const FAILURE = 0;
    const FAILURE_IDENTITY_NOT_FOUND = -1;
    const FAILURE_IDENTITY_AMBIGUOUS = -2;
    const FAILURE_CREDENTIAL_INVALID = -3;
    const FAILURE_UNCATEGORIZED = -4;

    public function __construct($code, $identity, array $messages = [
        0 => "Não foi possivel completar ação",
        1 => "Seja bem vindo",
        -1 => "Usuário ou senha incorreto",
        -2 => "Operação inválida",
        -3 => "Usuário ou senha incorreto",
        -4 => "Operação inválida",
    ]
    ) {

        switch ($code) {

            case Result::FAILURE:
                $this->setMessage("Operação inválida", "error");
                break;

            case Result::SUCCESS:
                $this->setMessage(sprintf($messages[$code], $identity), "success");
                break;

            case Result::FAILURE_IDENTITY_NOT_FOUND:
                $this->setMessage($messages[$code], "alert");
                break;

            case Result::FAILURE_IDENTITY_AMBIGUOUS:
                $this->setMessage($messages[$code], "alert");
                break;

            case Result::FAILURE_CREDENTIAL_INVALID:
                $this->setMessage($messages[$code], "alert");
                break;

            case Result::FAILURE_UNCATEGORIZED:
                $this->setMessage($messages[$code], "error");
                break;

            default:
                $this->message("Operação inválida", "error");
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message, $class = 'success') {
        $icon['success'] = 'ion-checkmark-round';
        $icon['info'] = 'ion-information-circled';
        $icon['alert'] = 'ion-alert-circled';
        $icon['error'] = 'ion-close-circled';
        $this->message = sprintf("<div class='alert alert_%s'><span>%s<i class='icone %s'></i> </span></div>", $class, $message, $icon[$class]);
    }

}
