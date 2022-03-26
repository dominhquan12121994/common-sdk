<?php
namespace Common\Auth;

use Common\Auth\Contracts\ISecretProvider;
use Common\Auth\Models\SessionUser;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Pal\Commons\SingleSignOn\User;

/**
 * Class PalUserProvider
 * Phục vụ cho single sign on
 */
abstract class AbstractPalUserProvider implements UserProviderContract
{

    /**
     * @param mixed $identifier
     * @return Authenticatable|mixed|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function retrieveById($identifier)
    {
        $userInfo = $this->getUserInfo($identifier);
        if(is_null($userInfo)){
            return null;
        }
        $user = app()->make(SessionUser::class);
        $user->fill($userInfo['data']['user']);
        $user->jwt = $identifier;
        return $user;
    }

    /**
     * @param array $credentials
     * @return Authenticatable|mixed|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function retrieveByCredentials(array $credentials)
    {
        if(!isset($credentials['api_token'])){
            return null;
        }
        return $this->retrieveById($credentials['api_token']);
    }

    /**
     * @param $identifier
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getUserInfo($identifier){
        $secrectProvider = app()->get(ISecretProvider::class);
        $pendingRequest =  $this->getPendingRequest($identifier);
        $info = $pendingRequest->get($secrectProvider->getUserInfoApi());
        if($info->status() == 200 && !is_null($info->json())){
            return $info->json();
        }
        return null;
    }

    /**
     * Get Request
     * @return PendingRequest
     */
    protected function getPendingRequest($jwt = null)
    {
        if(is_null($jwt)){
            return Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]);
        }else{
            return Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$jwt,
            ]);
        }
    }

    /**
     * @param $jwt
     * @return object|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function decodeJwt($jwt){
        try {
            return JWT::decode($jwt, app()->get(ISecretProvider::class)->getPublicKey(), [ISecretProvider::ENCRYPT_LOGIC]);
        }catch (\Exception $ex){
            Log::info($ex);
            return null;
        }
    }


    /**
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|void|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return $this->retrieveById($identifier);
    }

    /**
     * @param Authenticatable $user
     * @param string $token
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        return true;
    }
}
