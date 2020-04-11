<?php
namespace App\Repositories;

use App\Repositories\Interfaces\AuthInterface;

class AuthRepository implements AuthInterface
{
  public function grantPasswordToken($email, $password)
  {
    $params = [
        'grant_type' => 'password',
        'username' => $email,
        'password' => $password,
    ];

    return $this->makePostRequest($params);
  }

  public function refreshAccessToken()
  {
    $refreshToken = request()->cookie('refresh_token');
    
    abort_unless($refreshToken, 403, 'Your refresh token is expired.');

    $params = [
        'grant_type' => 'refresh_token',
        'refresh_token' => $refreshToken,
    ];

    return $this->makePostRequest($params);
  }
  public function makePostRequest(array $params)
  {
    $params = array_merge([
      'client_id' => config('services.passport.password_client_id'),
      'client_secret' => config('services.passport.password_client_secret'),
      'scope' => '*',
    ], $params);

    $proxy = \Request::create('oauth/token', 'post', $params);
    $response = json_decode(app()->handle($proxy)->getContent());
    
    $this->setHttpOnlyCookie($response->refresh_token);

    return $response;

  }

  public function setHttpOnlyCookie($refreshToken)
  {
    cookie()->queue(
        'refresh_token',
        $refreshToken,
        14400, // 10 days
        null,
        null,
        false,
        true // httponly
    );
  }

}