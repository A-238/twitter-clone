<?php
// いいね / いいね解除（Ajax用）
require_once('./init.php');

// 明示的に指定しない場合は、text/html型と判断される
header("Content-type: application/json; charset=UTF-8");

// 返戻データ
$res = [
    'result' => 'ng'
];

// ログインチェック
if (!Common::isLogin()) {
    //JSONデータを出力
    echo json_encode($res);
    exit;
}

if (Request::isAjax()) {
    // 自分のユーザーID
    $userId = $_SESSION['user_id'];

    $postParam = [
        'user_id' => $userId, // セッションから取得
        'post_id' => Request::post('post_id', ''), // 対象投稿のID
        'csrf_token' => Request::post('csrf_token', ''),
        'mode' => Request::post('mode', '') // 1: いいねする 0: いいねを外す
    ];

    $err = Like::validate($postParam);

    if (empty($err)) {
        $date = date("Y-m-d H:i:s");

        // モードによって処理分岐
        switch ($postParam['mode']) {
            // いいね
            case '1':
                // DB保存
                $data = [
                    'user_id' => $postParam['user_id'],
                    'post_id' => $postParam['post_id'],
                    'created_at' => $date
                ];

                try {
                    Db::create('likes', $data);
                    $res['result'] = 'ok';
                } catch (\PDOException $e) {
                    $res['err'] = $e->getMessage();
                }
                break;

            // フォロー解除
            case '0':
                try {
                    Like::delete($postParam['user_id'], $postParam['post_id']);
                    $res['result'] = 'ok';
                } catch (\PDOException $e) {
                    $res['err'] = $e->getMessage();
                }
                break;
        }
    }
}

echo json_encode($res);
exit;
