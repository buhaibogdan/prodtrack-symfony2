<?php


namespace Prodtrack\ClientBundle\Services;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    // TODO: move this to a config
    const URL_OAUTH_TOKEN = 'http://local.prodtrack.io/app_dev.php/oauth/token';

    public function getToken($username, $password, $clientId, $clientSecret, $grantType)
    {
        $params = array(
            'username' => $username,
            'password' => $password,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => $grantType
        );

        try {
            $token = $this->callOAuthService($params);
            // save refresh token
            // and expire time
            // in user session or db
            // other than oauth tables
            return $token['access_token'];
        } catch(UnauthorizedHttpException $e) {
            return false;
        } catch(BadRequestHttpException $e) {
            return false;
        }
    }

    public function callOAuthService($params)
    {
        $ch = curl_init(self::URL_OAUTH_TOKEN);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        switch($httpCode) {
            case 200:
                $return = json_decode($response, true);
                break;
            case 401:
                throw new UnauthorizedHttpException('');
            default:
                throw new BadRequestHttpException();
        }
        return $return;
    }
}