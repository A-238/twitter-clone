<?php
// 共通処理クラス
class Common
{
    // ログイン状態か？
    public static function isLogin()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }


    // ログイン状態でない場合はログインページへ遷移
    public static function loginCheck()
    {
        if (!self::isLogin()) {
            header('Location: ' . BASE_URL);
        }
    }


    // HTML特殊文字エスケープ
    public static function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }


    // CSRF対策トークンを生成しセッションに格納
    public static function createCsrfToken()
    {
        // 暗号学的的に安全なランダムなバイナリを生成し、それを16進数に変換することでASCII文字列に変換します
        $tokeByte = openssl_random_pseudo_bytes(16);
        $token = bin2hex($tokeByte);
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    
    // CSRFトークンをチェック
    public static function checkCsrfToken($token)
    {
        if ($token === $_SESSION['csrf_token']) {
            return true;
        }

        return false;
    }
}