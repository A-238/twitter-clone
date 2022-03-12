<?php
$html = '';
$baseUrl = BASE_URL;

if (!empty($posts)) {
    $oldId = '';

    foreach ($posts as $key => $post) {
        if ($oldId !== $post['post_id']) {
            $html .= '<div class="card w-150" style="margin-bottom: 10px;">';
            $html .= '    <div class="card-body">';
            $html .= '        <h5 class="card-title"><a href="' . $baseUrl .'/user.php?id=' . $post['user_id'] . '">' . Common::h($post['user_name']) . '</a></h5>';
            $html .= '        <h6 class="card-subtitle mb-2 text-muted">' . $post['created_at'] . '</h6>';
            $html .= '        <p class="card-text">' . Common::h($post['content']) . '</p>';
    
            // いいねボタン
            if ($post['is_like'] === 'Y') { // いいね済み
                $html .= '<span>';
                $html .= '    <button id="un_like_btn-' . $post['post_id'] . '" data-post-id="' . $post['post_id'] . '" type="button" class="btn btn-outline-success btn-sm">';
                $html .= '        <i class="fa fa-heart"></i>';
                $html .= '    </button>';
                $html .= '</span>';
            } else {
                $html .= '<span>';
                $html .= '    <button id="like_btn-' . $post['post_id'] . '" data-post-id="' . $post['post_id'] . '" type="button" class="btn btn-outline-secondary btn-sm">';
                $html .= '        <i class="fa fa-heart-o"></i>';
                $html .= '    </button>';
                $html .= '</span>';
            }

            $html .= '<button 
            type="button" 
            class="btn btn-outline-secondary btn-sm"
            style="margin-left: 5px;"
            data-toggle="collapse"
            data-target="#example-' . $post['post_id'] . '"
            aria-expand="false"
            aria-controls="example-' . $post['post_id'] . '">コメントを見る</button>';

            $html .= '<div class="collapse" id="example-' . $post['post_id'] . '">';
        }

        // コメント部分
        if (!empty($post['comment_id'])) {
            $html .= '<div class="card card-body" style="margin-top: 8px;">';
            $html .= '    <h5 class="card-title"><a href="' . $baseUrl. '/user.php?id=' . $post['comment_user_id'] . '">' . Common::h($post['comment_user_name']) . '</a></h5>';
            $html .= '    <h6 class="card-subtitle mb-2 text-muted">' . $post['comment_created_at'] . '</h6>';
            $html .= '    <p class="card-text">' . Common::h($post['comment_content']) . '</p>';
            $html .= '</div>';
        }

        // 次がある、かつ次のループは異なる投稿
        $isEnd = false;
        if (isset($posts[$key+1])) {
            if ($posts[$key+1]['post_id'] !== $post['post_id']) {
                $isEnd = true;
            }
        }
        // 最終ループ 
        else {
            $isEnd = true;
        }

        if ($isEnd) {
            $html .= '<div id="comment_form_div-' . $post['post_id'] . '" class="card card-body" style="margin-top: 8px;">';
            $html .= '    <form>';
            $html .= '        <div class="form-group">';
            $html .= '            <textarea class="form-control" rows="3" id="comment_form_content-' . $post['post_id'] . '"></textarea>';
            $html .= '            <span class="small">※全角140文字以内</span>';
            $html .= '        </div>';
            $html .= '    <button type="button" class="btn btn-primary btn-sm" id="comment_form_btn-' . $post['post_id'] . '" data-post-id="' . $post['post_id'] . '">コメントする</button>';
            $html .= '    </form>';
            $html .= '</div>';

            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $oldId = $post['post_id'];
    }
} else {
    $html .= '<p>つぶやきがありません</p>';
}

echo $html;