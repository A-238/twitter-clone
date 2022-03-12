<?php

class Comment extends Db
{
    public static $tableName = 'comments';

    
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

        // コメント本文
        if (isset($param['content'])) {
            $content = isset($param['content']) ? $param['content'] : null;

            // 必須チェック
            if (empty($content)) {
                $err[] = 'コメントを入力してください';
            } else {
                // マルチバイト文字列上限チェック
                if (Validate::isMbStrOverMaxLength($content, 140)) {
                    $err[] = 'コメントは全角140文字以内で入力してください';
                }
            }
        }

        return $err;
    }
}