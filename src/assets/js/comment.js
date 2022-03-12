
$(function(){

    // コメントボタン
    if($('[id^=comment_form_btn-]').length){
        const commentBtn = $('[id^=comment_form_btn-]');

        commentBtn.on('click', function() {
            onClickCommentBtn($(this));
        });
    }

    // コメント投稿処理
    const onClickCommentBtn = (btnElem) => {
        $(btnElem).prop("disabled", true);

        const postId = $(btnElem).data().postId;
        const content = $('#comment_form_content-' + postId).val();

        $.ajax({
            type: 'POST',
            url: BASE_URL + '/comment.php',
            data: {
                post_id: postId,
                csrf_token: csrfToken,
                content
            },
            dataType: 'json',
        }).done((res) => {
            // 処理成功
            if (res.result === 'ok') {
                // コメントフォームdiv
                const div = $('#comment_form_div-' + postId);

                // コメントカード生成
                let html = '';
                html += '<div class="card card-body" style="margin-top: 8px;">';
                html += '    <h5 class="card-title"><a href="' + BASE_URL + `/user.php?id=${res.user_id}">${res.user_name}</a></h5>`;
                html += `    <h6 class="card-subtitle mb-2 text-muted">${res.created_at}</h6>`;
                html += `    <p class="card-text">${res.content}</p>`;
                html += '</div>';

                div.before(html);

                $('#comment_form_content-' + postId).val('');
            } else {
                // エラーメッセージ
                if (res.err.length) {
                    let err = '';
                    console.log(res.err);
                    for (i in res.err) {
                        err += '・' + res.err[i] + "\n";
                    }

                    alert("コメントに失敗しました。以下を確認してください。\n" + err);
                } else {
                    alert("処理に失敗しました。\nお手数ですが更新してください。");
                }
            }

            $(btnElem).prop("disabled", false);
        }).fail((XMLHttpRequest, textStatus, error) => {
            console.log(error)
            alert("通信に失敗しました。\nお手数ですが更新してください。");
        });
    };
});