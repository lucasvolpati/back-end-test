<?php

namespace Source\Models;

use Source\Core\Model;

class Searches extends Model {

    protected static $entity = "searches";

    protected static $safe = ['id', 'created_at'];

    public $response;

    public function __construct()
    {
        $this->response['response_status']['status'] = 1;
    }

    public function bootstrap(string $credential, object $data)
    {
        $this->credential = $credential;
        $this->cep = $data->cep;
        $this->public_place = $data->logradouro;
        $this->complement = $data->complemento;
        $this->district = $data->bairro;
        $this->city = $data->localidade;
        $this->state = $data->uf;
        $this->ddd = $data->ddd;
        
        return $this;
    }

    public function find(string $terms, string $params, string $columns = "*") 
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if($this->fail() || !$find->rowCount()) {
            return null;
        }
        return $find->fetchAll();
    }

    public function getRegister(array $data, string $columns = "*")
    {
        $this->response['response_data']['list'] = $this->find("credential = :email", "email={$data['credential']}", "*, DATE_FORMAT(created_at, '%d/%m/%Y - %H:%i') as created_at");

        return $this->response;
    }

    public function save()
    {
        $this->create(self::$entity, $this->safe());
        if ($this->fail()) {
            $this->response['response_status']['status'] = 0;
            $this->response['response_status']['message'] = "Erro ao salvar a busca, tente novamente mais tarde.";
            $this->response['response_status']['error'] = $this->fail();

            return $this->response;
        }

        $this->response['response_status']['status'] = 1;
        $this->response['response_status']['message'] = "Pesquisa salva com sucesso!";

        return $this->response;
    }
}