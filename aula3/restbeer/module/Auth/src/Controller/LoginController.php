<?php

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Auth\Storage\Authenticate;
use Auth\Storage\Result;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {

    protected $authenticate;

    /**
     * @return mixed
     */
    public function getAuthenticate() {
        $this->authenticate = $this->containerInterface->get(Authenticate::class);
        return $this->authenticate;
    }

    /**
     * @var ContainerInterface
     */
    private $containerInterface;

    /**
     * LoginController constructor.
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface) {
        $this->containerInterface = $containerInterface;
    }

    public function loginAction() {
        $auth = $this->getAuthenticate();
        if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $form = $this->containerInterface->get(LoginForm::class);
        if ($this->params()->fromPost()):
            // Instantiate the authentication service:

            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {

                //RECUPERA OS DADOS VALIDADOS DO FORMULARIO
                $dataform = $form->getData();
                //VERIFICA SE O USUARIO EXISTE
                $result = $auth->login(
                        $dataform['email'], md5($dataform['password']), $this->getRequest()->getServer('HTTP_USER_AGENT'), $this->getRequest()->getServer('REMOTE_ADDR'));
                //CARREGA AS MENSSAGENS COM A CLASS RESULT
                $messagesResult = new Result($result->getCode(), $result->getIdentity());
                //SE VALIDO O USUARIO ENTRA AQUI
                if ($result->isValid()) {
                    //AUTHENTICADO COM SUCESSO
                    // $request['message']=$messagesResult->getMessage();
                    // $request['success']=$result->getCode();
                    // $request['redirect']="/admin";
                    return $this->redirect()->toRoute('home');
                }
            }

        endif;
        return new ViewModel(compact('form'));
    }

    public function logoutAction() {

        if ($this->getAuthenticate()->hasIdentity()) {
            $this->getAuthenticate()->logout();
        }
        return $this->redirect()->toRoute('login');
    }

}
