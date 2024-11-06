$(document).ready(function() {
    var strGET = window.location.search.replace('?', '');
    projectId = strGET.slice(3);
    
    $.ajax({
      url: `http://manage-back/project/${projectId}/edit`,
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        let managerOptions = '';
        if (data.managers && Array.isArray(data.managers)) {
          data.managers.forEach(manager => {
            const isSelected = data.project.id_manager === manager.id;
            managerOptions += `<option value="${manager.id}" ${isSelected ? 'selected' : ''}>${manager.name}</option>`;
          });
        } else {
          managerOptions = '<option value="">Выберите менеджера</option>';
        }
  
        let form = `
        <div class="container" style="width: 80%">
        <h1>Редактирование проекта</h1>

          <form id="saving_changes" method="POST">
            
            <div class="mb-3">
              <label for="name" class="form-label">Имя:</label>
              <input name="name" type="text" class="form-control" id="name" required value="${data.project.name || ''}">
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Руководитель:</label>
              <select class="form-select" id="role" name="id_manager">
                ${managerOptions}
              </select>
            </div>
            <button type="submit" class="btn btn-secondary" id="saving_changes">Сохранить</button>
          </form>
          </div>
        `;
        
        $('.container').html(form);
        
        $('#saving_changes').on('submit', function(e) {
          e.preventDefault();
          $.ajax({
            url: `http://manage-back/adminUpdateProject/${projectId}`,
            method: 'PUT', 
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
              console.log('Проект успешно обновлен:', response);
              alert('Проект успешно обновлен!');
              location.href = "allProject.html";
            },
            error: function(xhr, status, error) {
              console.error('Ошибка при обновлении:', error);
              alert('Ошибка при обновлении проекта.');
            }
          });
        });
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        alert('Ошибка при загрузке данных проекта.');
      }
    });
  });
  