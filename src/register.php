<?php
require_once('./controllers/registerController.php');
?>

<?php require_once('./views/layouts/top_header.php'); ?>

<div class="container">
    <?php if (!empty($err)): // エラーメッセージ ?>
        <div class="alert alert-danger" role="alert" style="margin-top: 15px">
            <?php foreach($err as $v): ?>
                <span>・<?= $v; ?><span><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">

        <form method="POST" action="<?= BASE_URL . '/register.php'; ?>">

            <h4 style="margin-top: 10px;">新規登録</h4>

            <div class="form-group" style="margin-top: 20px">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" class="form-control" 
                value="<?= isset($postParam['name']) ? Common::h($postParam['name']) : ''; ?>">
                <span class="small">15文字以内</span>
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="xxxxx@example.com" 
                value="<?= isset($postParam['email']) ? Common::h($postParam['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" class="form-control">
                <span class="small">英数字のみ、10文字以内</span><br>
                <span class="small" style="color: red">※メールアドレス、パスワードはログインの際に必要となります</span>
            </div>

            <div style="margin-top: 30px">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>">
                <button type="submit" class="btn btn-primary btn-lg">登録</button>
            </div>

            <div style="margin-top: 20px">
                <span class="small"><a href="<?= BASE_URL; ?>">ログインはこちら</a></span>
            </div>
        </form>
    </div>
</div>

<?php require_once('./views/layouts/footer.php'); ?>