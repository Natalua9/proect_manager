function addNavigationItems() {
    const navItems = document.getElementById('nav-items');
    
    // Проверка на наличие элемента
    if (!navItems) {
        console.error("Элемент nav-items не найден");
        return;
    }

    const userRole = sessionStorage.getItem("role");
    console.log("Роль пользователя:", userRole); // Проверка значения роли

    if (!userRole) {
        navItems.innerHTML =
            '<li class="nav-item"><a class="nav-link" href="../index.html">Вход</a></li>' ;
    } else {
        if (userRole === 'admin') {
            navItems.innerHTML =
                '<li class="nav-item"><a class="nav-link active" href="#"><h2>ProjectManagement</h2></a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="RegUser.html">Регистрация нового пользователя</a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="allProject.html">Проекты</a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="allUser.html">Пользователи системы</a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="statistics.html">Статистика</a></li>' +
                '<li class="nav-item" onclick="clearClientSession()"><button class="btn btn-secondary"" >Выход</button></li>';
        } else if (userRole === 'editor') {
            navItems.innerHTML =
                '<li class="nav-item"><a class="nav-link active" href="#"><h2>ProjectManagement</h2></a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="editorIndex.html">Проекты</a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="addProject.html">Создать проект</a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="statisticsEditor.html">Статистика</a></li>' +
                '<li class="nav-item" onclick="clearClientSession()"><button class="btn btn-secondary"" >Выход</button></li>';

        } else {
            navItems.innerHTML =
            '<li class="nav-item"><a class="nav-link active" href="#"><h2>ProjectManagement</h2></a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="userIndex.html">Мои задачи</a></li>' +
                '<li class="nav-item"><a class="nav-link active" href="statisticsUser.html">Статистика</a></li>' +
                '<li class="nav-item" onclick="clearClientSession()"><button class="btn btn-secondary"" >Выход</button></li>';

        }
    }
}

// Вызываем функцию после загрузки DOM
window.addEventListener('DOMContentLoaded', addNavigationItems);

function clearClientSession() {
    sessionStorage.clear();

    console.log("Данные сессии клиента очищены.");
    location.href= '../index.html';
  }