$(document).ready(function() {
    var strGET = window.location.search.replace('?', '');
    projectId = strGET.slice(3);
    
    $.ajax({
      url: `http://manage-back/editorProject/${projectId}/edit`,
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
        <h1>Редактирование проекта</h1>

          <form id="saving_changes" method="POST">
           <div class="card" style="width: 100%;">   
                <div class="card-body">   
                    <div class="mb-3">  
                        <label for="name" class="form-label">Название проекта</label>  
                        <input type="text" class="form-control" id="name" name="name" value="${data.project.name || ''}" required>
                    </div>  
                    <div class="mb-3">  
                        <label for="description" class="form-label">Описание проекта</label>  
                        <input type="text" class="form-control" id="description" name="description" value="${data.project.description || ''}" required>
                    </div>  
                    <div class="mb-3">   
                        <label for="status" class="form-label">Статус</label>   
                        <select class="form-select" id="status" name="status"> 
                            <option value="Создан" ${('status', data.project.status) === 'Создан' ? 'selected' : ''}>Создан</option> 
                            <option value="В процессе" ${('status', data.project.status) === 'В процессе' ? 'selected' : ''}>В процессе</option>
                            <option value="Завершен" ${('status', data.project.status) === 'Завершен' ? 'selected' : ''}>Завершен</option> 
                        </select> 
                    </div>  
                    <div class="mb-3">  
                        <label for="date_start" class="form-label">Дата начала</label>  
                        <input type="date" class="form-control" id="date_start" name="date_start" value="${data.project.date_start || ''}" required>
                    </div> 
                    <div class="mb-3">  
                        <label for="date_end" class="form-label">Дата окончания</label>  
                        <input type="date" class="form-control" id="date_end" name="date_end" value="${data.project.date_end || ''}" required>
                    </div> 
                     
                </div>   
                <div class="card-body">   
                    <button type="submit" class="btn btn-secondary">Сохранить изменения</button>   
                </div>   
            </div>   
          </form>
        `;
        
        $('.container').html(form);
        
        $('#saving_changes').on('submit', function(e) {
          e.preventDefault();
          $.ajax({
            url: `http://manage-back/updateProject/${projectId}`,
            method: 'PUT', 
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
              console.log('Проект успешно обновлен:', response);
              alert('Проект успешно обновлен!');
              location.href = "editorIndex.html";
            },
            error: function(xhr, status, error) {
              console.error('Ошибка при обновлении:', error);
              alert('Произошла ошибка при обновлении проекта. Попробуйте еще раз.');
            }
          });
        });
      },
      error: function(xhr, status, error) {
        console.error('Ошибка при получении данных:', error);
        alert('Произошла ошибка при загрузке проекта. Попробуйте еще раз.');
      }
    });
});