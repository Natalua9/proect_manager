$(document).ready(function() {
  var strGET = window.location.search.replace('?', '');
  userId = strGET.slice(3);
  
  $.ajax({
    url: `http://manage-back/users/${userId}/edit`,
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      let roleOptions = '';
      for (const [value, label] of Object.entries(data.roles)) {
        const selected = (value === data.user.role) ? 'selected' : '';
        roleOptions += `<option value="${value}" ${selected}>${label}</option>`;
      }

      let form = `
            <h1>Редактирование пользователя</h1>

        <form id="saving_changes" method="POST">
          
          <div class="mb-3">
            <label for="name" class="form-label">Имя:</label>
            <input name="name" type="text" class="form-control" id="name" value="${data.user.name}">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input name="email" type="email" class="form-control" id="email" value="${data.user.email}">
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Роль:</label>
            <select class="form-select" id="role" name="role">
              ${roleOptions}
            </select>
          </div>
          <button type="submit" class="btn btn-secondary" id="saving_changes">Сохранить</button>
        </form>
      `;
      
      $('.container').html(form);
      
      $('#saving_changes').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: `http://manage-back/users/${userId}`,
          method: 'PATCH', 
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            console.log('Пользователь успешно обновлен:', response);
            alert('Пользователь успешно обновлен!');
            location.href = "allUser.html";

          },
          error: function(xhr, status, error) {
            console.error('Ошибка при обновлении:', error);
            alert('Ошибка при обновлении пользователя.');
          }
        });
      });
    },
    error: function(xhr, status, error) {
      console.error('Error:', error);
      alert('Ошибка при загрузке данных пользователя.');
    }
  });
});
