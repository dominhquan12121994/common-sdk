<?php
namespace Common\Auth\Contracts;

interface ISecretProvider
{
    /**
     * Logic encrypt
     */
    const ENCRYPT_LOGIC = 'RS256';

    /**
     * @return mixed
     */
    public function getUserInfoApi();

    /**
     * @return mixed
     */
    public function getPublicKey();
}
