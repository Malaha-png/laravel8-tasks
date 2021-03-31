<?php

namespace App\Http\Controllers;

use App\Models\Passwords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function init(Request $request)
    {
        if ($request->Authorization != 'secret') return;

        $mass = Passwords::orderBy('created_at', 'DESC')->get();
        $AESMethod = new AESMethod();
        foreach ($mass as $key => &$value) {
            $mass[$key]->password = $AESMethod->decoder($value->password);
        }
        return $mass;
    }

    public function create(Request $request)
    {
        $newpass = new Passwords;
        $newpass->appName = $request->item['appName'];
        $AESMethod = new AESMethod();
        $newpass->password = $AESMethod->encoder($request->item['password']);
        // $newpass->password = $request->item['password'];
        $newpass->description = $request->item['description'];

        $newpass->save();

        return $newpass;
    }

    public function show(Request $request)
    {

        if ($request->Authorization != 'secret') return;
        $id = $request->item['id'];
        $existingPasswords = Passwords::find($id);
        if ($existingPasswords) {
            $AESMethod = new AESMethod();
            $existingPasswords->password = $AESMethod->decoder($existingPasswords->password);
            return $existingPasswords;
        } else {
            return '{}';
        }
    }
}

interface encoderDecoder
{
    public function encoder($txt);
    public function decoder($txt);
}


class AESMethod implements encoderDecoder
{
    public function encoder($txt)
    {
        $key =  getenv('KEY_ENCDEC');
        $plaintext = $txt;
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
        return $ciphertext;
    }

    public function decoder($txt)
    {
        $key =  getenv('KEY_ENCDEC');
        $c = base64_decode($txt);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
    }
}
