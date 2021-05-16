var publicPath = 'http://mobile-app-store.herokuapp.com/';

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
                        body: (data && data.responseJSON && data.responseJSON.err) || 'Có lỗi xảy ra',
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

/*
 *  
 * for developer/upgrade.php
 * 
 */
function developer_upgrade() {
    function clickUprade() {
        var name = $('#name').val(),
            address = $('#address').val(),
            email = $('#email').val(),
            phone = $('#phone').val(),
            checkImg1 = $('#checkImg1').val(),
            checkImg2 = $('#checkImg2').val();


        if (!name || !address || !email || !phone || !checkImg1 || !checkImg2) {
            alert('Vui lòng nhập đầy đủ thông tin');
            return;
        }

        if (balance < 500000) {
            alert('Bạn không đủ tiền để thanh toán');
            return;
        }

        $('#submitFormUprade').submit();

    }
    window.clickUprade = clickUprade;

    $(function () {
        $("#img_cmnd_1").change(function () {
            if (this.files[0].size > 0) {
                $('#checkImg1').val('1');
            } else {
                $('#checkImg1').val('');
            }
        });

        $("#img_cmnd_2").change(function () {
            if (this.files[0].size > 0) {
                $('#checkImg2').val('1');
            } else {
                $('#checkImg2').val('');
            }
        });
    })
}


if (location.pathname.endsWith('/developer/upgrade.php')) {
    developer_upgrade();
}

/*
 *  
 * for developer/upload-application.php
 * 
 */
function developer_upload_application() {
    function clickPostAppTemp() {
        var name = $('#name').val(),
            descript = $('#descript').val(),
            descript_detail = $('#descript_detail').val(),
            category = $('#category').val(),
            category_app = $('#category_app').val(),
            price = $('#price').val(),
            checkIcon = $('#checkIcon').val(),
            checkFileSetting = $('#checkFileSetting').val(),
            checkImgList = $('#checkImgList').val();

        if (!name || !category || !category_app) {
            alert('Bạn phải nhập Name , Tên thể loại , Loại ứng dụng');
            return;
        }
        $('#checkPostAppSave').val('');
        $('#submitFormPostApp').submit();
    }
    window.clickPostAppTemp = clickPostAppTemp;

    function clickPostApp() {
        var name = $('#name').val(),
            descript = $('#descript').val(),
            descript_detail = $('#descript_detail').val(),
            category = $('#category').val(),
            category_app = $('#category_app').val(),
            price = new Number($('#price').val()),
            checkIcon = $('#checkIcon').val(),
            checkFileSetting = $('#checkFileSetting').val(),
            checkImgList = $('#checkImgList').val();

        if (!name || !descript || !descript_detail || !category || !category_app
            || !checkIcon || !checkFileSetting || !checkImgList) {
            $er = name + descript + descript_detail + category + category_app + checkIcon + checkFileSetting + checkImgList;
            console.log($er);

            alert('Bạn phải nhập hết các trường');
            return;
        }
        if (category_app == 'not_free' && price <= 0) {
            alert('Giá phí phải > 0');
            return;
        }
        $('#checkPostAppSave').val('1');
        $('#submitFormPostApp').submit();
    }
    window.clickPostApp = clickPostApp;

    $(function () {
        $("#category_app").change(function () {
            var val = $(this).val();
            if (val == 'not_free') {
                $('#show-price-app').show();
            } else {
                $('#show-price-app').hide();
                $('#price').val('');
            }
        });

        $("#icon").change(function () {
            if (this.files[0].size > 0) {
                $('#checkIcon').val('1');
            } else {
                $('#checkIcon').val('');
            }
        });

        $("#file_setting").change(function () {
            var check_extention = $(this).val();
            var extension = check_extention.split('.').pop().toLowerCase();

            if (this.files.length > 0) {
                if ($.inArray(extension, ['zip']) == -1) {
                    alert("File ứng dụng phải là file .zip");
                    $(this).val('');
                    return;
                }

                if (this.files[0].size >= 1000000) {
                    alert('Dung lượng file phải < 1000000');
                    $(this).val('');
                    $('#checkFileSetting').val('');
                    return;
                } else {
                    $('#checkFileSetting').val('1');
                }
            }

        });

        $("#img_list").change(function () {
            if (this.files[0].size > 0) {
                $('#checkImgList').val('1');
            } else {
                $('#checkImgList').val('');
            }
        });
    })
}

if (location.pathname.endsWith('/developer/upload-application.php')) {
    developer_upload_application();
}


/*
 *  
 * for developer/update-application.php
 * 
 */

function developer_update_application() {
    function clickPostAppTemp() {
        var name = $('#name').val(),
            descript = $('#descript').val(),
            descript_detail = $('#descript_detail').val(),
            category = $('#category').val(),
            category_app = $('#category_app').val(),
            price = $('#price').val(),
            checkIcon = $('#checkIcon').val(),
            checkFileSetting = $('#checkFileSetting').val(),
            checkImgList = $('#checkImgList').val();

        if (!name || !category || !category_app) {
            alert('Bạn phải nhập Name , Tên thể loại , Loại ứng dụng');
            return;
        }
        $('#checkPostAppSave').val('');
        $('#submitFormPostApp').submit();
    }
    window.clickPostAppTemp = clickPostAppTemp;

    function clickPostApp() {
        var name = $('#name').val(),
            descript = $('#descript').val(),
            descript_detail = $('#descript_detail').val(),
            category = $('#category').val(),
            category_app = $('#category_app').val(),
            price = $('#price').val(),
            checkIcon = $('#checkIcon').val(),
            checkFileSetting = $('#checkFileSetting').val(),
            checkImgList = $('#checkImgList').val();

        if (!name || !descript || !descript_detail || !category || !category_app
            || !checkIcon || !checkFileSetting || !checkImgList) {
            alert('Bạn phải nhập hết các trường');
            return;
        }
        $('#checkPostAppSave').val('1');
        $('#submitFormPostApp').submit();
    }
    window.clickPostApp = clickPostApp;

    $(document).ready(function () {

        if (icon_p) {
            $('#checkIcon').val('1');
        }
        if (img_list_p) {
            $('#checkImgList').val('1');
        }
        if (file_setting) {
            $('#checkFileSetting').val('1');
        }

        $("#category_app").change(function () {
            var val = $(this).val();
            if (val == 'not_free') {
                $('#show-price-app').show();
            } else {
                $('#show-price-app').hide();
                $('#price').val('');
            }
        });

        $("#icon").change(function () {
            if (this.files[0].size > 0) {
                $('#checkIcon').val('1');
            } else {
                $('#checkIcon').val('');
            }
        });

        $("#file_setting").change(function () {
            if (status == 2) {
                $('#checkFileSetting').val('1');
                alert('Không được thay đổi file cài đặt');
                return;
            }

            var check_extention = $(this).val();
            var extension = check_extention.split('.').pop().toLowerCase();

            if (this.files.length > 0) {
                if ($.inArray(extension, ['zip']) == -1) {
                    alert("File ứng dụng phải là file .zip");
                    $(this).val('');
                    return;
                }

                if (this.files[0].size >= 1000000) {
                    alert('Dung lượng file phải < 1000000');
                    $(this).val('');
                    $('#checkFileSetting').val('');
                    return;
                } else {
                    $('#checkFileSetting').val('1');
                }
            }

        });

        $("#img_list").change(function () {
            if (this.files[0].size > 0) {
                $('#checkImgList').val('1');
            } else {
                $('#checkImgList').val('');
            }
        });
    });
}

if (location.pathname.endsWith('/developer/update-application.php')) {
    developer_update_application();
}

/*
 *  
 * for developer/my-dev-app
 * 
 */

function developer_my_dev_app() {
    function resetStatusApp(id, status, user_id_current) {
        var result = confirm("Bạn có muốn gỡ không ?");
        if (result) {
            $.ajax({
                url: './ajax/ajax_reset_status.php',
                method: "POST",
                data: {
                    id: id,
                    status: status,
                    user_cd: user_id_current
                },
                dataType: 'JSON',
                success: function (res) {
                    location.reload();
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
    }
    window.resetStatusApp = resetStatusApp;
}

if (location.pathname.endsWith('/developer/my-dev-app.php')) {
    developer_my_dev_app();
}


/*
 *  
 * for admin/category
 * 
 */

function admin_category() {
    $(function () {
        $('#createBtn').click(function (event) {
            event.preventDefault()
            var $val = $('#create-input');
            var val = $val.val();
            val = val.trim();
            if (!val) {
                $val.addClass('is-invalid');
                commonModal({
                    title: 'Thông báo',
                    body: 'Tên của thể loại bị trống',
                    buttons: {
                        yes: {
                            class: ['btn-primary'],
                            name: 'Đồng ý', click: function (modalId, close) {
                                close();
                            }
                        }
                    }
                });
                return;
            } else {
                $val.removeClass('is-invalid');
                $.post('', { name: val, action: 'create' }, function (data) {
                    location.reload();
                })
                    .fail(function (data) {
                        commonModal({
                            title: 'Thông báo',
                            body: (data && data.responseJSON && data.responseJSON.err) || 'Có lỗi xảy ra',
                            buttons: {
                                yes: {
                                    class: ['btn-primary'],
                                    name: 'Đồng ý', click: function (modalId, close) {
                                        location.reload();
                                    }
                                }
                            }
                        });
                    })
            }
        });

        $('a[action=update]').click(function (event) {
            event.preventDefault()
            var id = $(this).attr('data-id');
            var $val = $('input[data-id=' + id + ']');
            var val = $val.val();
            val = val.trim();
            if (!val) {
                $val.addClass('is-invalid');
                return;
            } else {
                $val.removeClass('is-invalid');
                commonModal({
                    title: 'Xác nhận',
                    body: 'Bạn có muốn cập nhật không',
                    buttons: {
                        yes: {
                            name: 'Đồng ý',
                            class: ['btn-primary'],
                            click: function (modalId, close) {
                                $.post('', { id: id, name: val, action: 'update' }, function (data) {
                                    location.reload();
                                })
                                    .fail(function (data) {
                                        commonModal({
                                            title: 'Thông báo',
                                            body: (data && data.responseJSON && data.responseJSON.err) || 'Có lỗi xảy ra',
                                            buttons: {
                                                yes: {
                                                    class: ['btn-primary'],
                                                    name: 'Đồng ý', click: function (modalId, close) {
                                                        location.reload();
                                                    }
                                                }
                                            }
                                        });
                                    })
                            }
                        },
                        no: {
                            name: 'Không',
                            class: ['btn-secondary'],
                            click: function (modalId, close) {
                                close();
                            }
                        }
                    }
                });
            }

        });

        $('a[action=delete]').click(function () {
            event.preventDefault()
            var id = $(this).attr('data-id');
            commonModal({
                title: 'Thông báo',
                body: 'Bạn có thực sự muốn xóa',
                buttons: {
                    yes: {
                        class: ['btn-danger'],
                        name: 'Đồng ý', click: function (modalId, close) {
                            $.post('', { id: id, action: 'delete' }, function (data) {
                                location.reload();
                            })
                                .fail(function (data) {
                                    commonModal({
                                        title: 'Thông báo',
                                        body: (data && data.responseJSON && data.responseJSON.err) || 'Có lỗi xảy ra',
                                        buttons: {
                                            yes: {
                                                class: ['btn-primary'],
                                                name: 'Đồng ý', click: function (modalId, close) {
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                })
                        }
                    },
                    no: {
                        name: 'Không',
                        click: function (modalId, close) {
                            close();
                        }
                    }
                }
            });
        });
    })
}

if (location.pathname.endsWith('/admin/category.php')) {
    admin_category();
}

/*
 *  
 * for admin/money-card.php
 * 
 */


function admin_card() {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
}


if (location.pathname.endsWith('/admin/money-card.php')) {
    admin_card();
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