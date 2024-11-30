$(document).ready(function() {

    let $registerModal = $('#registration');
    let $authModal = $('#auth');
    let $userInfoModal = $('#user_info_modal');

    // появление модального окна регистрации
    $('#register-btn').on('click', function ()
    {
        $registerModal.addClass('modal-active');
    });

    // появление модального окна авторизации
    $('#auth-btn').on('click', function ()
    {
        $authModal.addClass('modal-active');
    });

    // появление модального окна информации о пользователе
    $('.user-info-tr').on('click', function (){
        $userInfoModal.addClass('modal-active');

        let $this = $(this);
        $.ajax({
            url: '/ajax/user_info.php',
            type: 'POST',
            data: {
                action: 'open_modal',
                id: $this.attr('data-user-id')
            },
            success: function (response) {
                let responseParse = JSON.parse(response);
                if (responseParse['success'] === 'Y') {
                    $.each(responseParse['user_info'], function (key, value) {
                        $('#user_info_modal input[name="' + key + '"]').val(value);
                    });
                    $('#delete_user_btn').attr('data-user-id', responseParse['user_info']['id']);
                    $('#save_changes_btn').attr('data-user-id', responseParse['user_info']['id']);
                }
            }
        });
    });

    // функция закрытия модального окна
    function closeModal(e, _this) {
        let $modal = $('.modal-wrapper');
        if (!$modal.is(e.target) && $modal.has(e.target).length === 0) {
            $(_this).removeClass('modal-active');
        }
    }

    // закрытие модального окна при клике вне его
    $registerModal.on('click', function (e)
    {
        closeModal(e, this);
    });
    
    $authModal.on('click', function (e)
    {
        closeModal(e, this);
    });

    $userInfoModal.on('click', function (e)
    {
        closeModal(e, this);
    });

    //регистрация пользователя
    $('#register-user-btn').on('click', function (){
        let $register_wrapper = $('.modal .modal-wrapper');
        $register_wrapper.find('.warning-label').remove();
        let $warningLabel = $('.modal-wrapper .warning-label');
        $.ajax({
            url: '/ajax/registration.php',
            type: 'post',
            data: $('#register_form').serialize(),
            success: function (response) {
                let responseParse = JSON.parse(response);
                if (typeof responseParse['inputs_errors'] !== 'undefined') {
                    $.each(responseParse['inputs_errors'], function( inputName, error ) {
                        $('input[name="' + inputName + '"').before('<div class="warning-label">' + error + '</div>');
                    });
                }
                if (typeof responseParse['error'] !== 'undefined') {
                    if ($warningLabel.length === 0) {
                        $('#register_signup').before('<div class="warning-label">' + responseParse['error'] + '</div>');
                    }
                }
                if (responseParse['success'] === 'Y') {
                    location.reload();
                }
            }
        });
    });

    // авторизация пользователя
    $('#auth-user-btn').on('click', function ()
    {
        let _this = this;
        let $warningLabel = $('#auth .warning-label');
        if ($warningLabel.length !== 0) {
            $warningLabel.remove();
        }
        $.ajax({
            url: '/ajax/auth.php',
            type: 'POST',
            data: {
                login: $("#auth input[name='login']").val(),
                password: $("#auth input[name='password']").val()
            },
            success: function (reply) {
                if (reply !== 'Y') {
                    $(_this).before(reply);
                } else {
                    location.reload();
                }
            }
        });
    });

    // сохранить изменения о пользователе
    $('#save_changes_btn').on('click', function ()
    {
        let $this = $(this);
        let $warningLabel = $('#user_info_modal .warning-label');
        if ($warningLabel.length !== 0) {
            $warningLabel.remove();
        }

        $.ajax({
            url: '/ajax/user_info.php',
            type: 'post',
            data: {
                id: $this.attr('data-user-id'),
                name: $("#user_info_modal input[name='name']").val(),
                login: $("#user_info_modal input[name='login']").val(),
                action: 'change'
            },
            success: function (response) {
                let responseParse = JSON.parse(response);
                if (responseParse['success'] === 'Y') {
                    location.reload();
                } else {
                    if (typeof responseParse['error'] !== 'undefined') {
                        $this.before('<div class="warning-label">' + responseParse['error'] + '</div>');
                    }
                }
            }
        });
    });

    // удалить пользователя
    $('#delete_user_btn').on('click', function ()
    {
        $.ajax({
            url: '/ajax/user_info.php',
            type: 'post',
            data: {
                id: $(this).attr('data-user-id'),
                action: 'delete'
            },
            success: function (response) {
                let responseParse = JSON.parse(response);
                if (responseParse['success'] === 'Y') {
                    location.reload();
                }
            }
        });
    });

});