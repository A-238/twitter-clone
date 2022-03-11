<?php
require_once('./core/init.php');
?>

<?php require_once('./views/layouts/header.php'); ?>

<div class="container">
    <div class="row">
        <form>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" class="form-control" placeholder="email">
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" class="form-control" placeholder="Password">
            </div>

            <div class="mx-auto" style="width: 200px;">
                <button type="button" class="btn btn-primary btn-lg">ログイン</button>
                <a href="#" class="btn btn-link">新規作成</a>
            </div>
        </form>
    </div>
</div>

<?php require_once('./views/layouts/footer.php'); ?>