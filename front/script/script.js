$(document).ready(() => {
    $("#signup_user").submit((event) => {
        event.preventDefault(); // предотвращаем обычную отправку формы
        $.ajax({
            url: "http://manage-back/register", 
            method: "POST",
            data: $("#signup_user").serialize(),
            success: (response) => {
                location.href = "../admin/allUser.html";
                console.log(response);
                sessionStorage.setItem("name", response);
            },
            error: (xhr) => {
                console.log("Ошибка:", xhr.responseJSON); // выводим ошибки
            }
        });
    });
});
$(document).ready(() => {
    $("#signin_user").submit((event) => {
        event.preventDefault();
        $.ajax({
            url: "http://manage-back/login", 
            method: "POST",
            data: $("#signin_user").serialize(),
            success: (response) => {
                console.log(response);
                const role = response.role;// Получаем роль из ответа
                const email = response.email; 
                const id = response.id; 
                sessionStorage.setItem("id", id);
                sessionStorage.setItem("role", role);
                sessionStorage.setItem("email", email);
                if (role === 'admin') {
                    location.href = "../admin/allUser.html";
                } else if (role === 'user') {
                    location.href = "../user/userIndex.html";
                } else if (role === 'editor') {
                    location.href = "editor/editorIndex.html";
                }
            },
            error: (xhr) => {
                console.log("Ошибка:", xhr.responseJSON);
                alert(xhr.responseJSON ? xhr.responseJSON.error : "Произошла ошибка при авторизации");
            }
        });
    });
});
