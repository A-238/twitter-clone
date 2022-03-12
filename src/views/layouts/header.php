<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8"/>
    <title>Pets</title>
    <meta name="description" content="ペットのようすをつぶやくSNS">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <!-- ナビゲーション -->
    <nav class="navbar navbar-dark bg-dark">
        <a href="<?= BASE_URL; ?>" class="navbar-brand">Pets</a>
        <button class="navbar-toggler" type="button"
            data-toggle="collapse"
            data-target="#navmenu1"
            aria-controls="navmenu1"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navmenu1">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="<?= BASE_URL . '/home.php'; ?>">ホーム</a>
                <a class="nav-item nav-link" href="<?= BASE_URL . '/all_user.php'; ?>">ユーザー一覧</a>
                <a class="nav-item nav-link" href="<?= BASE_URL . '/logout.php'; ?>">ログアウト</a>
            </div>
        </div>
    </nav>