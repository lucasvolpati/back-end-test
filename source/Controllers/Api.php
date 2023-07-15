<?php

namespace Source\Controllers;

use Source\Models\Searches;

class Api {

    protected static $httpCode = [400,200];

    protected $cep;

    public function getAddress(array $cep)
    {
        $this->cep = mb_strpos(trim($cep['cep']), '-') ? str_replace("-", '', trim($cep['cep'])) : trim($cep['cep']);

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

        echo $this->getResult($this->cep);
    }

    protected function getResult(string $cep) {
        $all = getallheaders();
        
        $save = isset($all['save-search']) ? $all['save-search'] : 'no';
        $credential = isset($all['save-search']) == 'yes' ? $all['client-credential'] : '';

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
            CURLOPT_HTTPHEADER => [
                "save-search: {$save}",
                "client-credential: {$credential}"
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        // if ($save === 'yes') {
            $search = new Searches();
            $array = json_decode($response);
            $result = $search->bootstrap($credential, '['.$response.']')->save();
        // }

    var_dump($result);

        return $response;
    }
}