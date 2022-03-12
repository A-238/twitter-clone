<?php
// フォロー / アンフォロー（Ajax用）
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
        'follow_id' => Request::post('follow_id', ''), // 対象ユーザーのID
        'csrf_token' => Request::post('csrf_token', ''),
        'mode' => Request::post('mode', '') // 1: フォローする 0: フォローを外す
    ];

    $err = Relationship::validate($postParam);

    if (empty($err)) {
        $date = date("Y-m-d H:i:s");

        // モードによって処理分岐
        switch ($postParam['mode']) {
            // フォロー
            case '1':
                // DB保存
                $data = [
                    'user_id' => $postParam['user_id'],
                    'follow_id' => $postParam['follow_id'],
                    'created_at' => $date
                ];

                try {
                    Db::create('relationships', $data);
                    $res['result'] = 'ok';
                } catch (\PDOException $e) {
                    $res['err'] = $e->getMessage();
                }
                break;

            // フォロー解除
            case '0':
                try {
                    Relationship::delete($postParam['user_id'], $postParam['follow_id']);
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
