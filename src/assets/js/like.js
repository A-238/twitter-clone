
$(function(){

    // いいねボタン
    if($('[id^=like_btn-]').length){
        const likeBtn = $('[id^=like_btn-]');

        likeBtn.on('click', function() {
            onClickLikeBtn($(this));
        });
    }

    // いいね解除ボタン
    if($('[id^=un_like_btn-]').length){
        const unLikeBtn = $('[id^=un_like_btn-]');

        unLikeBtn.on('click', function() {
            onClickUnLikeBtn($(this));
        });
    }

    // いいね処理
    const onClickLikeBtn = (btnElem) => {
        $(btnElem).prop("disabled", true);

        const postId = $(btnElem).data().postId;

        $.ajax({
            type: 'POST',
            url: BASE_URL + '/like.php',
            data: {
                post_id: postId,
                csrf_token: csrfToken,
                mode: '1'
            },
            dataType: 'json',
        }).done((res) => {
            // 処理成功
            if (res.result === 'ok') {
                const span = $(btnElem).parent();

                $(btnElem).fadeOut('slow').queue(function() {
                    this.remove();

                    // いいね解除ボタン生成
                    const unLikeBtn = $('<button><i class="fa fa-heart"></i></button>');
                    unLikeBtn.attr('type', 'button');
                    unLikeBtn.attr('id', 'un_like_btn-' + postId);
                    unLikeBtn.attr('data-post-id', postId);
                    unLikeBtn.addClass('btn btn-outline-success btn-sm');
                    unLikeBtn.on('click', function () {
                        onClickUnLikeBtn($(this));
                    });

                    span.append(unLikeBtn);
                });
            } else {
                alert("処理に失敗しました。\nお手数ですが更新してください。");
            }
        }).fail((XMLHttpRequest, textStatus, error) => {
            console.log(error)
            alert("通信に失敗しました。\nお手数ですが更新してください。");
        });
    };

    // いいね解除処理
    const onClickUnLikeBtn = (btnElem) => {
        $(btnElem).prop("disabled", true);

        const postId = $(btnElem).data().postId;

        $.ajax({
            type: 'POST',
            url: BASE_URL + '/like.php',
            data: {
                post_id: postId,
                csrf_token: csrfToken,
                mode: '0'
            },
            dataType: 'json',
        }).done((res) => {
            // 処理成功
            if (res.result === 'ok') {
                const span = $(btnElem).parent();
                
                $(btnElem).fadeOut('slow').queue(function() {
                    this.remove();

                    // いいねボタン生成
                    const likeBtn = $('<button><i class="fa fa-heart-o"></i></button>');
                    likeBtn.attr('type', 'button');
                    likeBtn.attr('id', 'like_btn-' + postId);
                    likeBtn.attr('data-post-id', postId);
                    likeBtn.addClass('btn btn-outline-secondary btn-sm');
                    likeBtn.on('click', function () {
                        onClickLikeBtn($(this));
                    });

                    span.append(likeBtn);
                });
            } else {
                alert("処理に失敗しました。\nお手数ですが更新してください。");
            }
        }).fail((XMLHttpRequest, textStatus, error) => {
            console.log(error)
            alert("通信に失敗しました。\nお手数ですが更新してください。");
        });
    };
});