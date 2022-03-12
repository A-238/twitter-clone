<?php

class Relationship extends Db
{
    public static $tableName = 'relationships';

    
    // 連想配列でセットした値をバリデーション
    public static function validate($param = [])
    {
        $err = [];

        // CSRFチェック
        if (!Common::checkCsrfToken($param['csrf_token'])) {
            $err[] = '不正な操作です';
            return $err;
        }

        // user_id
        if (isset($param['user_id'])) {
            $userId = isset($param['user_id']) ? $param['user_id'] : null;

            // 必須チェック
            if (empty($userId)) {
                $err[] = 'ユーザーIDが存在しません';
            }
        }

        // follow_id
        if (isset($param['follow_id'])) {
            $followId = isset($param['follow_id']) ? $param['follow_id'] : null;

            // 必須チェック
            if (empty($followId)) {
                $err[] = '対象ユーザーIDが存在しません';
            }
        }

        // 自身に対してフォロー、アンフォロー処理はできない
        if (isset($param['user_id']) && isset($param['follow_id'])) {
            if ($param['user_id'] === $param['follow_id']) {
                $err[] = '不正な操作です';
            }
        }

        return $err;
    }


    public static function delete($userId, $followId)
    {
        $sql = 'DELETE '
            .  ' FROM ' . self::$tableName
            .  ' WHERE user_id = :user_id '
            .  '  AND follow_id = :follow_id ';

        $param = [
            ':user_id' => $userId,
            ':follow_id' => $followId,
        ];

        return Db::execute($sql, $param);
    }


    // フォローしているユーザーデータを取得
    public static function getFollow($userId)
    {
        $sql = 'SELECT '
            .  ' follow_id '
            .  ' FROM ' . self::$tableName
            .  ' WHERE user_id = :user_id ';

        $param = [
            ':user_id' => $userId
        ];

        return Db::fetchAll($sql, $param);
    }
}