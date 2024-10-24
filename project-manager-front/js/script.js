$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(()=>{
    $('#create_user__form').on('submit', (event)=>{
        event.preventDefault();
         console.log($("form").serialize());


        $.ajax({
            url:"http://prod-man-public/api/admin/users",
            method:"POST",
            data: $("#create_user__form").serialize(),
            success:(response)=>{
                console.log(response);
            },
            error: (xhr, status, error) => {
                console.log("Ошибка создания:", xhr.responseText);
            }
        })
    });




    $('#signin_form').on('submit', (event)=>{
        event.preventDefault();

        $.ajax({
            url:"http://prod-man-public/api/admin//users/signin",
            method:"POST",
            data: $("#signin_form").serialize(),
            success:(response)=>{
                console.log(response);
            },
            error: (xhr, status, error) => {
                console.log("Ошибка создания:", xhr.responseText);
            }
        })
    })
});


