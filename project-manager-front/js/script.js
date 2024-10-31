$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(() => {
    $('#create_user__form').on('submit', (event) => {
        event.preventDefault();
        console.log($("form").serialize());


        $.ajax({
            url: "http://prod-man-public/api/admin/users",
            method: "POST",
            data: $("#create_user__form").serialize(),
            success: (response) => {
                console.log(response);
            },
            error: (xhr, status, error) => {
                console.log("Ошибка создания:", xhr.responseText);
            }
        })
    });




    $('#signin_form').on('submit', (event) => {
        event.preventDefault();

        $.ajax({
            url: "http://prod-man-public/api/admin/users/signin",
            method: "POST",
            data: $("#signin_form").serialize(),
            success: (response) => {
                console.log(response);

                if (response.status === 'ok') {
                    $('#response-message').text('Авторизация успешна!'); // Сообщение об успехе
                    window.location.href = 'http://project-manager-front/account.html'; // Редирект на страницу личного кабинета
                } else {
                    $('#response-message').text('Ошибка: ' + response.message); // Сообщение об ошибке
                }
            },
            error: (xhr, status, error) => {
                console.log("Ошибка создания:", xhr.responseText);
            }
        })
    });



});


function getPageUserState(userId) {
    $.ajax({
        url: 'http://prod-man-public/api/user/statistics',
        type: 'GET',
        data: { id_user: userId },
        success: function (response) {
            const { data } = response;
            $('.MyState').append(`
                <p> $(data.totalTasks) </p>
                <p> $(data.completedTasks) </p>
                <p> $(data.inProgressTasks) </p>
                <p> $(data.commentCount) </p>

                `);

        },
        error: function (xhr, status, error) {
            console.error('Произошла ошибка: ' + status);

        }

    });
};

