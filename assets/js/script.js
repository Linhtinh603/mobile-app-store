var publicPath = '/AppStoreOffshore/src/';

/*
 *  
 * for app/detail
 * 
 */

function app_detail() {
    $(function () {
        $('#buyNowBtn').click(function () {
            if (!isLogin) {
                commonModal({
                    title: 'Thông báo',
                    body: 'Bạn chưa đăng nhập, nhấn đồng ý để chuyển đến trang đăng nhập',
                    buttons: {
                        yes: {
                            class: ['btn-primary'],
                            name: 'Đồng ý', click: function (modalId, close) {
                                location.href = publicPath + '/account/login.php?redirect=' + location.href;
                            }
                        }
                    }
                });
                return;
            }
            $.post(publicPath + 'app/purchase.php', { id: id }, function (data) {
                setTimeout(function () {
                    location.href = publicPath + "app/download.php?id=" + id;
                }, 3000, publicPath)
                commonModal({
                    title: 'Thông báo',
                    body: data.responseJSON.msg,
                    buttons: {
                        yes: {
                            name: 'Đồng ý', click: function (modalId, close) {
                                close();
                            }
                        }
                    }
                });
            })
                .fail(function (data) {
                    commonModal({
                        title: 'Thông báo',
                        body: data.responseJSON.err || 'Có lỗi xảy ra',
                        buttons: {
                            yes: {
                                name: 'Đồng ý', click: function (modalId, close) {
                                    location.reload();
                                }
                            }
                        }
                    });
                })
        })
    })
}

if (location.pathname.endsWith('/app/detail.php')) {
    app_detail();
}

function commonModal(option) {
    var modalId = 'commonModal';
    var modalQuery = '#' + modalId;
    $(modalQuery + ' .modal-title').text(option.title);
    $(modalQuery + ' .modal-body > p').text(option.body);

    function close() {
        $(modalQuery).modal('hide')
    }

    $(modalQuery + ' .modal-footer').empty();
    for (var buttonName in option.buttons) {
        var button = option.buttons[buttonName];

        button.class = button.class || [];
        var template = '<button id="' + buttonName + '" class="btn ' + button.class.join(' ') + '">' + button.name + '</button>';

        $(modalQuery + ' .modal-footer').append(template);
        var handlerClick = function () {
            this.button.click(this.modalId, this.close)
        }.bind({ modalId: modalId, close: close, button: button })
        $(modalQuery + ' #' + buttonName).click(handlerClick)
    }

    $(modalQuery).modal('show');

}