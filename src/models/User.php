<?php 

class User extends Db
{
    public static $tableName = 'users';


    // 連想配列でセットした値をバリデーション
    public static function validate($param = [], $isSignUp = false)
    {
        $err = [];

        // CSRFチェック
        if (!Common::checkCsrfToken($param['csrf_token'])) {
            $err[] = '不正な操作です';
            return $err;
        }

        // ユーザー名
        if (isset($param['name'])) {
            $name = isset($param['name']) ? $param['name'] : null;

            // 必須チェック
            if (empty($name)) {
                $err[] = 'ユーザー名を入力してください';
            } else {
                // 上限チェック
                if (Validate::isStrOverMaxLength($name, 15)) {
                    $err[] = 'ユーザー名は15文字以内で入力してください';
                }
            }
        }

        // メールアドレス
        if (isset($param['email'])) {
            $email = isset($param['email']) ? $param['email'] : null;

            // 必須チェック
            if (empty($email)) {
                $err[] = 'メールアドレスを入力してください';
            } else {
                // 「RFC822」に準拠したメールアドレスか
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $err[] = 'メールアドレスが不正です';
                }
            }
        }

        // パスワード
        if (isset($param['password'])) {
            $password = isset($param['password']) ? $param['password'] : null;

            // 必須チェック
            if (empty($password)) {
                $err[] = 'パスワードを入力してください';
            } else {
                // 英数字のみ
                if (!Validate::isAlphabetAndNumOnly($password)) {
                    $err[] = 'パスワードは英数字のみで入力してください';
                }

                // 上限チェック
                if (Validate::isStrOverMaxLength($password, 10)) {
                    $err[] = 'パスワードは10文字以内で入力してください';
                }
            }
        }

        if ($isSignUp && empty($err)) {
            try {
                $user = self::getData($param['email']);
                if (!empty($user)) {
                    $err[] = 'このメールアドレスは既に登録されています';
                }
            } catch (\PDOException $e) {
                var_dump('Exception: ' . $e->getMessage());
            }
        }

        return $err;
    }


    // メールアドレスでユーザー情報取得
    public static function getData($email)
    {
        $sql = 'SELECT '
            .  ' * '
            .  ' FROM ' . self::$tableName
            .  ' WHERE email = :email ';

        $param = [
            ':email' => $email
        ];

        return Db::fetch($sql, $param);
    }


    // IDでユーザー情報取得
    public static function getDataById($id)
    {
        $sql = 'SELECT '
            .  ' * '
            .  ' FROM ' . self::$tableName
            .  ' WHERE id = :id ';

        $param = [
            ':id' => $id
        ];

        return Db::fetch($sql, $param);
    }


    // 全ユーザー情報取得
    public static function getAll()
    {
        $sql = 'SELECT '
            .  ' * '
            .  ' FROM ' . self::$tableName
            .  ' ORDER BY created_at DESC ';

        return Db::fetchAll($sql);
    }
}