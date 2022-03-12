<?php
require_once('./controllers/userController.php');
?>

<?php require_once('./views/layouts/header.php'); ?>

<div class="container">
    <a href="<?= BASE_URL . '/home.php'; ?>" class="small">ホームページ > </a>
    <h4 style="margin-top: 10px;">ユーザー詳細ページ</h4>

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
        <?php if (!empty($user)): ?>

            <div class="col col-lg-4" style="margin-top: 15px">
                <p class="small">ユーザー情報</p>
                <div class="card card-body">
                    <h5 class="card-title"><?= Common::h($user['name']); ?></h5>
                    <div>
                        <?php if (!$isOwn): // ログインユーザー以外の場合のみ表示 ?>
                            <?php if (in_array($userId, $ownFollowList, true)): // 既にフォローしている場合 ?>
                                <button id="un_follow_btn-<?= $user['id']; ?>" type="button" class="btn btn-danger btn-sm" data-user-id=<?= $user['id']; ?>>フォロー解除</button>
                            <?php else: ?>
                                <button id="follow_btn-<?= $user['id']; ?>" type="button" class="btn btn-primary btn-sm" data-user-id=<?= $user['id']; ?>>フォローする</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col col-lg-8" style="margin-top: 15px">
                <p class="small"><?= Common::h($user['name']); ?>さんのペットのようす</p>
                
                <?php require_once('./views/elements/post_list.php'); // 投稿一覧表示エレメント ?>
            </div>

        <?php endif; ?>
    </div>
</div>
<script>
    const csrfToken = "<?= $csrfToken; ?>";
</script>

<?php require_once('./views/layouts/footer.php'); ?>