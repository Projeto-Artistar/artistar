<?php


namespace Source\Core;

use League\Plates\Engine;
use PDO;

class Core
{

    protected $view;

    protected $nucleo;

    protected $router;

    protected $homenPath = 'artistar';

    protected $logado = false;

    protected $user = null;

    protected $NoSQL = NULL;
    
    protected $SQL = NULL;

    public function __construct($router = ROOT){
        global $db;
        $this->router=$router;
        $this->view = new Engine(dirname(__DIR__,1)."/Theme");
        $this->nucleo = $this->view;
        
        $this->SQL = $db;
        $this->verificaLogado();
        $this->view->addData(["router"=> $this->router]);

    }

    public function setUserLogonStatus($user) {
        $_SESSION['artistar']['logon'] = $user;
    }

    public function getUserLogonStatus() {
        return isset($_SESSION['artistar']['logon']) ? $_SESSION['artistar']['logon'] : null;
    }

    public function unsetUserLogonStatus() {
        unset($_SESSION['artistar']['logon']);
    }

    public function verificaLogado(){
        $this->setLogado(false);
        if(!empty($this->getUserLogonStatus())) {
            $userStatement = $this->SQL->prepare('
                SELECT
                    usu.usuario_id id,
                    usu.usuario_nome nome,
                    usu.usuario_nome_completo nome_completo,
                    usu.usuario_email email,
                    usu.usuario_email_validado email_validado,
                    usu.usuario_envio_validacao envio_validacao,
                    loj.loja_id loja_id
                FROM
                    usuarios usu
                LEFT JOIN
                    lojas loj ON usu.usuario_id = loj.loja_proprietario
                WHERE
                    usu.usuario_id = :id
            ');
            $userId = $this->getUserLogonStatus();
            $userStatement->bindParam(':id', $userId, PDO::PARAM_INT);
            $userStatement->execute();
            $result = $userStatement->fetch();
            if($result) {
                $this->setLogado(true);
                $this->setUser($result);
            } else {
                $this->unsetUserLogonStatus();
            }
        }
    }

    public function setLogado ($logado) {
        $this->logado = $logado;
    }

    public function getLogado () {
        return $this->logado;
    }

    public function setUser ($user) {
        $this->user = $user;
        $_SESSION['artistar']['user'] = $user;
    }

    public function getUser () {
        return $this->user;
    }

    public function validaAcesso($redirectToValidation = true) {
        if(!$this->getLogado()){
            header("location: /login");
            exit;
        } 
        if($redirectToValidation) $this->checkIfEmailIsValidated();
    }

    public function checkIfEmailIsValidated() {
        if (!$this->getUser()['email_validado']) {
            header("location: /register/validate-email");
            exit;
        } 
    }

    public function getEstados() {
        return [
            ['id' => 1, 'name' => 'Acre', 'uf' => 'AC'],
            ['id' => 2, 'name' => 'Alagoas', 'uf' => 'AL'],
            ['id' => 3, 'name' => 'Amapá', 'uf' => 'AP'],
            ['id' => 4, 'name' => 'Amazonas', 'uf' => 'AM'],
            ['id' => 5, 'name' => 'Bahia', 'uf' => 'BA'],
            ['id' => 6, 'name' => 'Ceará', 'uf' => 'CE'],
            ['id' => 7, 'name' => 'Distrito Federal', 'uf' => 'DF'],
            ['id' => 8, 'name' => 'Espírito Santo', 'uf' => 'ES'],
            ['id' => 9, 'name' => 'Goiás', 'uf' => 'GO'],
            ['id' => 10, 'name' => 'Maranhão', 'uf' => 'MA'],
            ['id' => 11, 'name' => 'Mato Grosso', 'uf' => 'MT'],
            ['id' => 12, 'name' => 'Mato Grosso do Sul', 'uf' => 'MS'],
            ['id' => 13, 'name' => 'Minas Gerais', 'uf' => 'MG'],
            ['id' => 14, 'name' => 'Pará', 'uf' => 'PA'],
            ['id' => 15, 'name' => 'Paraíba', 'uf' => 'PB'],
            ['id' => 16, 'name' => 'Paraná', 'uf' => 'PR'],
            ['id' => 17, 'name' => 'Pernambuco', 'uf' => 'PE'],
            ['id' => 18, 'name' => 'Piauí', 'uf' => 'PI'],
            ['id' => 19, 'name' => 'Rio de Janeiro', 'uf' => 'RJ'],
            ['id' => 20, 'name' => 'Rio Grande do Norte', 'uf' => 'RN'],
            ['id' => 21, 'name' => 'Rio Grande do Sul', 'uf' => 'RS'],
            ['id' => 22, 'name' => 'Rondônia', 'uf' => 'RO'],
            ['id' => 23, 'name' => 'Roraima', 'uf' => 'RR'],
            ['id' => 24, 'name' => 'Santa Catarina', 'uf' => 'SC'],
            ['id' => 25, 'name' => 'São Paulo', 'uf' => 'SP'],
            ['id' => 26, 'name' => 'Sergipe', 'uf' => 'SE'],
            ['id' => 27, 'name' => 'Tocantins', 'uf' => 'TO'],
        ];
    }

    public function generateValidationCode($length = 6) {
        return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    public function renderApiResponse($code, $message, $data = null) {
        $result = [];
        $result['code'] = $code;
        $result['message'] = $message;
        if (!empty($data)) $result['data'] = $data;
        return $this->view->render("apiResponse", [
            'result' => $result 
        ]);
    }

    public function moveFile($source, $destination) {
        if (!file_exists($source)) {
            return false;
        }
        $root = dirname(__DIR__, 2) . "/datafiles/";
        $fullDestination = $root . $destination;
        if (!file_exists(dirname($fullDestination))) {
            mkdir(dirname($fullDestination), 0777, true);
        }
        if (move_uploaded_file($source, $fullDestination)) {
            return "/datafiles/" . $destination;
        } else {
            return false;
        }
    }
}