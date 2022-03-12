
$(function(){

    // フォローボタン
    if($('[id^=follow_btn-]').length){
        const followBtn = $('[id^=follow_btn-]');

        followBtn.on('click', function() {
            onClickFollowBtn($(this));
        });
    }

    // フォロー解除ボタン
    if($('[id^=un_follow_btn-]').length){
        const unFollowBtn = $('[id^=un_follow_btn-]');

        unFollowBtn.on('click', function() {
            onClickUnFollowBtn($(this));
        });
    }

    // フォロー処理
    const onClickFollowBtn = (btnElem) => {
        $(btnElem).prop("disabled", true);

        const followId = $(btnElem).data().userId;

        $.ajax({
            type: 'POST',
            url: BASE_URL + '/relation.php',
            data: {
                follow_id: followId,
                csrf_token: csrfToken,
                mode: '1'
            },
            dataType: 'json',
        }).done((res) => {
            // 処理成功
            if (res.result === 'ok') {
                const div = $(btnElem).parent();

                $(btnElem).fadeOut('slow').queue(function() {
                    this.remove();

                    // フォロー解除ボタン生成
                    const unFollowBtn = $("<button>フォロー解除</button>");
                    unFollowBtn.attr('type', 'button');
                    unFollowBtn.attr('id', 'un_follow_btn-' + followId);
                    unFollowBtn.attr('data-user-id', followId);
                    unFollowBtn.addClass('btn btn-danger btn-sm');
                    unFollowBtn.on('click', function () {
                        onClickUnFollowBtn($(this));
                    });

                    div.append(unFollowBtn);
                });
            } else {
                alert("処理に失敗しました。\nお手数ですが更新してください。");
            }
        }).fail((XMLHttpRequest, textStatus, error) => {
            console.log(error)
            alert("通信に失敗しました。\nお手数ですが更新してください。");
        });
    };

    // フォロー解除処理
    const onClickUnFollowBtn = (btnElem) => {
        $(btnElem).prop("disabled", true);

        const followId = $(btnElem).data().userId;

        $.ajax({
            type: 'POST',
            url: BASE_URL + '/relation.php',
            data: {
                follow_id: followId,
                csrf_token: csrfToken,
                mode: '0'
            },
            dataType: 'json',
        }).done((res) => {
            // 処理成功
            if (res.result === 'ok') {
                const div = $(btnElem).parent();
                
                $(btnElem).fadeOut('slow').queue(function() {
                    this.remove();

                    // フォローボタン生成
                    const unFollowBtn = $("<button>フォローする</button>");
                    unFollowBtn.attr('type', 'button');
                    unFollowBtn.attr('id', 'follow_btn-' + followId);
                    unFollowBtn.attr('data-user-id', followId);
                    unFollowBtn.addClass('btn btn-primary btn-sm');
                    unFollowBtn.on('click', function () {
                        onClickFollowBtn($(this));
                    });

                    div.append(unFollowBtn);
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