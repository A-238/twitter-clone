<?php

class Like extends Db
{
    public static $tableName = 'likes';

    
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

        // post_id
        if (isset($param['post_id'])) {
            $postId = isset($param['post_id']) ? $param['post_id'] : null;

            // 必須チェック
            if (empty($postId)) {
                $err[] = '投稿IDが存在しません';
            }
        }

        return $err;
    }


    public static function delete($userId, $postId)
    {
        $sql = 'DELETE '
            .  ' FROM ' . self::$tableName
            .  ' WHERE user_id = :user_id '
            .  '  AND post_id = :post_id ';

        $param = [
            ':user_id' => $userId,
            ':post_id' => $postId,
        ];

        return Db::execute($sql, $param);
    }
}