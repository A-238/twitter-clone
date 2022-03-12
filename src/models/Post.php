<?php

class Post extends Db
{
    public static $tableName = 'posts';

    
    // 連想配列でセットした値をバリデーション
    public static function validate($param = [])
    {
        $err = [];

        // CSRFチェック
        if (!Common::checkCsrfToken($param['csrf_token'])) {
            $err[] = '不正な操作です';
            return $err;
        }

        // ユーザーID
        if (isset($param['user_id'])) {
            $userId = isset($param['user_id']) ? $param['user_id'] : null;

            // 必須チェック
            if (empty($userId)) {
                $err[] = 'ユーザーIDが存在しません';
            } else {
                if ($userId !== $_SESSION['user_id']) {
                    $err[] = '不正な操作です';
                }
            }
        }

        // つぶやき
        if (isset($param['content'])) {
            $content = isset($param['content']) ? $param['content'] : null;

            // 必須チェック
            if (empty($content)) {
                $err[] = 'つぶやきを入力してください';
            } else {
                // マルチバイト文字列上限チェック
                if (Validate::isMbStrOverMaxLength($content, 140)) {
                    $err[] = 'つぶやきは全角140文字以内で入力してください';
                }
            }
        }

        return $err;
    }


    // 指定ユーザーの投稿のみを取得
    public static function getOnlyUserData($userId, $loginUserId)
    {
        $sql = 'SELECT '
            .  '    p.id AS post_id '
            .  '  , p.user_id '
            .  '  , p.content '
            .  '  , p.created_at '
            .  '  , u.name AS user_name '
            .  '  , c.id AS comment_id '
            .  '  , c.content AS comment_content '
            .  '  , c.created_at AS comment_created_at '
            .  '  , u2.id AS comment_user_id '
            .  '  , u2.name AS comment_user_name '
            .  "  , (CASE WHEN l.post_id IS NULL THEN 'N' ELSE 'Y' END) AS is_like " // いいね判定
            .  ' FROM ' . self::$tableName . ' AS p '
            .  '  INNER JOIN users AS u ON u.id = p.user_id '
            .  '  LEFT JOIN likes AS l ON l.user_id = :login_user_id AND l.post_id = p.id '
            .  '  LEFT JOIN comments AS c ON c.post_id = p.id '
            .  '  LEFT JOIN users AS u2 ON u2.id = c.user_id '
            .  ' WHERE p.user_id = :user_id '
            .  '  AND p.deleted_at IS NULL '
            .  ' ORDER BY p.created_at DESC ';

        $param = [
            ':user_id' => $userId,
            ':login_user_id' => $loginUserId
        ];

        return Db::fetchAll($sql, $param);
    }


    // 指定ユーザーと、指定ユーザーがフォローしているユーザーの投稿、紐づくコメントを取得
    public static function getUserAndFollowUserData($userId)
    {
        $sql = 'SELECT '
            .  '    p.id AS post_id '
            .  '  , p.user_id '
            .  '  , p.content '
            .  '  , p.created_at '
            .  '  , u.name AS user_name '
            .  '  , c.id AS comment_id '
            .  '  , c.content AS comment_content '
            .  '  , c.created_at AS comment_created_at '
            .  '  , u2.id AS comment_user_id '
            .  '  , u2.name AS comment_user_name '
            .  "  , (CASE WHEN l.post_id IS NULL THEN 'N' ELSE 'Y' END) AS is_like " // いいね判定
            .  ' FROM ' . self::$tableName . ' AS p '
            .  '  INNER JOIN users AS u ON u.id = p.user_id '
            .  '  LEFT JOIN likes AS l ON l.user_id = :user_id AND l.post_id = p.id '
            .  '  LEFT JOIN comments AS c ON c.post_id = p.id '
            .  '  LEFT JOIN users AS u2 ON u2.id = c.user_id '
            .  ' WHERE p.user_id = :user_id '
            .  '  OR p.user_id IN (SELECT follow_id FROM relationships WHERE user_id = :user_id) '
            .  '  AND p.deleted_at IS NULL '
            .  ' ORDER BY p.created_at DESC ';

        $param = [
            ':user_id' => $userId
        ];

        return Db::fetchAll($sql, $param);
    }
}