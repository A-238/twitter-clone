<?php
require_once('./controllers/all_userController.php');
?>

<?php require_once('./views/layouts/header.php'); ?>

<div class="container">
    <a href="<?= BASE_URL . '/home.php'; ?>" class="small">ホームページ > </a>
    <h4 style="margin-top: 10px;">ユーザー一覧ページ</h4>
    <div class="row">
        <?php if (!empty($users)): ?>

            <div class="col col-lg-8">

                <?php foreach ($users as $user): ?>
                    <div class="card card-body" style="margin-top: 15px;">
                        <h5 class="card-title"><a href="<?= BASE_URL . '/user.php?id=' . $user['id']; ?>"><?= Common::h($user['name']); ?></a></h5>
                        <h6 class="card-subtitle mb-2 text-muted">登録日: <?= $user['created_at']; ?></h6>
                        <div>
                            <?php if ($_SESSION['user_id'] !== $user['id']): // ログインユーザー以外 ?>
                                <?php if (in_array($user['id'], $ownFollowList, true)): // 既にフォローしている場合 ?>
                                    <button id="un_follow_btn-<?= $user['id']; ?>" type="button" class="btn btn-danger btn-sm" data-user-id=<?= $user['id']; ?>>フォロー解除</button>
                                <?php else: ?>
                                    <button id="follow_btn-<?= $user['id']; ?>" type="button" class="btn btn-primary btn-sm" data-user-id=<?= $user['id']; ?>>フォローする</button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="col col-lg-4"></div>

        <?php endif; ?>
    </div>
</div>
<script>
    const csrfToken = "<?= $csrfToken; ?>";
</script>

<?php require_once('./views/layouts/footer.php'); ?>