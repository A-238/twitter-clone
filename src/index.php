<?php require_once('./controllers/indexController.php'); ?>

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
        <form method="POST" action="<?= BASE_URL . '/'; ?>">

            <h4 style="margin-top: 10px;">ログイン</h4>

            <div class="form-group" style="margin-top: 20px">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control" 
                value="<?= isset($postParam['email']) ? Common::h($postParam['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div style="margin-top: 30px">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>">
                <button type="submit" class="btn btn-primary btn-lg">ログイン</button>
            </div>

            <div style="margin-top: 20px">
                <span class="small"><a href="<?= BASE_URL . '/register.php'; ?>">新規登録はこちら</a></span>
            </div>
        </form>
    </div>
</div>

<?php require_once('./views/layouts/footer.php'); ?>