<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fifa;

/**
 * Description of Signature
 *
 * @author oscar.ruiz
 */
class Signature {

    private function key() {
        $rsa = new \phpseclib\Crypt\RSA();
        extract($rsa->createKey());
        return ['privatekey' => $privatekey, 'publickey' => $publickey];
    }

    public function sign($document, $privatekey) {
        openssl_sign($document, $signature, $privatekey, OPENSSL_ALGO_SHA256);
        return $signature;
    }

    public function create($document) {
        $key = $this->key();
        $signature = $this->sign($document, $key['privatekey']);
        return['privatekey' => $key['privatekey'], 'publickey' => $key['publickey'], 'signature' => $signature];
    }

    public function validate($document, $signature, $publickey) {

        $publickey = openssl_pkey_get_public($publickey);
        $output = '';
        $ok = openssl_verify($document, $signature, $publickey, "sha256WithRSAEncryption");

        if ($ok == 1) {
            $output = TRUE;
        } else {
            $output = FALSE;
        }

        // liberar la clave de la memoria
        openssl_free_key($publickey);
        return $output;
    }

}
