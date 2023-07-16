# Back-end test

## 💻 Hello there!

This project is a simple API to get address bypassing postal code (only for Brazil)

### Demo
<a href='https://lucasalcantara.dev.br/back-end/'>Click here</a> to visit the history page, and type your e-mail to get your addresses

## 1º Step
```
composer install
```

## Localhost Endpoint
### api/cep/{cep}/{save}
In *cep* variable you need to entry the zip code number, with 8 digits, and the *save* variable will receive *yes* or *no* if you want to save this query in history, but for this, you should send the header *client-credential* with your e-mail, follow curl example:

```
curl_setopt_array($curl, [
  CURLOPT_URL => 'https://www.localhost/back-end/api/cep/15625000/yes',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => [
    'client-credential: lucas.volpati@outlook.com'
  ],
]);
```

## Demo Endpoint
### api/cep/{cep}/{save}
You only need change the url to 'https://www.lucasalcantara.dev.br/back-end/api/cep/{cep}/{save}'.

Make good use and good luck.
### Developer
* [Lucas A. R. Volpati] | <lucas.volpati@outlook.com> - Developer of this app!
* [Back-end test] - Yeah 🤘