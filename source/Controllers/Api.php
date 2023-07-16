<?php

namespace Source\Controllers;

use Source\Models\Searches;

class Api {

    /*** @var int[] */
    protected static $httpCode = [400,200];

    /*** @var */
    protected $cep;

    /**
     * @param array $data
     * @return void
     */
    public function getAddress(array $data)
    {
        $this->cep = mb_strpos(trim($data['cep']), '-') ? str_replace("-", '', trim($data['cep'])) : trim($data['cep']);

        $pattern = "/^[0-9]{8}$/";

        if (!preg_match($pattern, $this->cep)) {
            http_response_code(self::$httpCode[1]);

            $error = [
                'http-code' => 400,
                'message' => 'ZIP Code number needs to be 8 digits long, you entered ' . strlen($this->cep)
            ];
            echo json_encode($error);

            header("HTTP/1.1 400");
            return;
        }

        $request = $this->getResult($this->cep, $data['save']);

        $error = '{}';
        if ($request['response_status']['save-status'] == 0) {
            $error = json_encode($request['response_status']);
        }

        $curlReturn = $request['response_data']['curl'];
        $responseReturn = json_encode($request['response_status']);

        echo '[' . $curlReturn .','. $responseReturn .','. $error . ']';
    }

    /**
     * @param string $cep
     * @param string $save
     * @return array
     */
    protected function getResult(string $cep, string $save) {

        $all = getallheaders();
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "viacep.com.br/ws/{$cep}/json/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response['response_data']['curl'] = curl_exec($curl);

        curl_close($curl);

        if ($save === 'yes' && isset($all['client-credential'])) {
            $search = new Searches();
            $result = $search->bootstrap($all['client-credential'], json_decode($response['response_data']['curl']))->save();

            $response['response_status']['save-status'] = 1;
            $response['response_status']['message'] = 'Solicitação realizada com sucesso! Para consultar seus endereços salvos acesse https://lucasalcantara.dev.br/api-cep e informe seu e-mail.';
            $response['response_status']['return'] = $result;

            return $response;
        }

        if ($save === 'yes' && !isset($all['client-credential'])) {
            $response['response_status']['save-status'] = 0;
            $response['response_status']['message'] = 'Impossivel salvar a consulta, o e-mail do usuario nao foi informado no header da requisicao. Ver instrucoes em https://github.com/lucasvolpati/back-end-test';

            return $response;
        }

        $response['response_status']['save-status'] = 0;
        $response['response_status']['status'] = 1;
        $response['response_status']['message'] = 'Solicitação realizada com sucesso!';
        
        return $response;        
    }
}
