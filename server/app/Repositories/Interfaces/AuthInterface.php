<?php

namespace App\Repositories\Interfaces;

interface AuthInterface
{
  public function grantPasswordToken($email, $password);
  public function refreshAccessToken();
  public function makePostRequest(array $params);
  public function setHttpOnlyCookie($refreshToken);
}