<?php

namespace Source\Models;

use Source\Core\Model;

class Searches extends Model {

    protected static $entity = "searches";

    protected static $safe = ['id', 'created_at'];

    public $response;

    public function bootstrap(string $credential, $json)
    {
        $this->credential = $credential;
        $this->json = $json;
        
        return $this;
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