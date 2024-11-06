$(document).ready(function () {
  // Функция для загрузки пользователей
  function loadUsers(role = '') {
      $.ajax({
          url: 'http://manage-back/home',
          type: 'GET',
          dataType: 'json',
          data: { role: role }, // Передаем выбранную роль
          success: function (data) {
              let tbody = $('table tbody');
              tbody.empty();

              $.each(data, function (index, users) {
                  let row = $('<tr>');
                  row.append($('<td>').text(users.name));
                  row.append($('<td>').text(users.email));
                  row.append($('<td>').text(users.role));
                  row.append($('<td>').append($(`<a class="btn btn-success">`).attr("href", `adminUpdateUser.html?id=${users.id}`).text('Изменить')));
                  
                  // Кнопка удаления пользователя
                  let deleteButton = $('<button class="btn btn-danger">').text('Удалить').attr('data-id', users.id);
                  deleteButton.on('click', function () {
                      let userId = $(this).data('id');
                      if (confirm('Вы уверены, что хотите удалить пользователя?')) {
                          $.ajax({
                              url: `http://manage-back/usersdestroy/${userId}`,
                              type: 'DELETE',
                              success: function (response) {
                                  alert('Пользователь успешно удален');
                                  loadUsers(role); // Обновляем данные после удаления
                              },
                              error: function (xhr, status, error) {
                                  console.error('Error:', error);
                                  alert('Ошибка при удалении пользователя.');
                              }
                          });
                      }
                  });
                  row.append($('<td>').append(deleteButton));
                  tbody.append(row);
              });
          },
          error: function (xhr, status, error) {
              console.error('Error:', error);
              alert('Ошибка при загрузке данных пользователей.');
          }
      });
  }

  // Изначальная загрузка пользователей
  loadUsers();

  // Обработчик изменения фильтра по роли
  $('#roleFilter').change(function () {
      let role = $(this).val();
      loadUsers(role); // Загружаем пользователей с выбранной ролью
  });
});