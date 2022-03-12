<?php
require_once('./controllers/homeController.php');
?>

<?php require_once('./views/layouts/header.php'); ?>

<div class="container">
    <h4 style="margin-top: 10px;">ホームページ</h4>

    <?php if (!empty($flashMsg)): // ログイン成功メッセージ ?>
        <div class="alert alert-primary" role="alert" style="margin-top: 15px">
            <?= $flashMsg; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($err)): // エラーメッセージ ?>
        <div class="alert alert-danger" role="alert" style="margin-top: 15px">
            <?php foreach($err as $v): ?>
                <span>・<?= $v; ?><span><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">

        <div class="col col-lg-4" style="margin-top: 15px">
        
            <p class="small">ユーザー情報</p>
            <div class="card card-body">
                <h5 class="card-title"><?= Common::h($user['name']); ?></h5>
            </div>

            <span class="small">ペットの様子をつぶやいてみよう！</span>
            <form method="POST" action="<?= BASE_URL . '/home.php'; ?>">
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="content"><?= isset($postParam['content']) ? Common::h($postParam['content']) : ''; ?></textarea>
                    <span class="small">※全角140文字以内</span>
                </div>

                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>">
                <button type="submit" class="btn btn-primary btn-sm">つぶやく</button>
            </form>
        </div>

        <div class="col col-lg-8" style="margin-top: 15px">
            <span class="small">みんなのペットのようす</span>
            
            <?php require_once('./views/elements/post_list.php'); // 投稿一覧表示エレメント ?>

        </div>
    </div>
</div>
<script>
    const csrfToken = "<?= $csrfToken; ?>";
</script>

<?php require_once('./views/layouts/footer.php'); ?>