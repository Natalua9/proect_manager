$(document).ready(function () { 
  $.ajax({ 
      url: 'http://manage-back/project', 
      type: 'GET', 
      dataType: 'json', 
      success: function (data) { 
          let container = $('.project-container'); // Используем класс для поиска контейнера 
          container.empty(); // Очищаем контейнер 


          $.each(data, function (index, project) { 
              let tasksHtml = ''; 

              // Логирование проекта и его задач 
              console.log(`Project: ${project.name}`, project.project_task); 

              // Проверяем, есть ли у проекта задачи 
              console.log();
              
              if (Array.isArray(project.project_task) && project.project_task.length > 0) { 
                  tasksHtml += '<ul>'; 
                  $.each(project.project_task, function (taskIndex, task) { 
                      tasksHtml += `<li>${task.name} - Статус: ${task.status}</li>`; 
                  }); 
                  tasksHtml += '</ul>'; 
              } else { 
                  tasksHtml = '<p>Нет задач для этого проекта.</p>'; 
              } 

              let card = ` 
                  <div class="card mb-3" style="width: 18rem;"> 
                      <div class="card-body"> 
                          <h5 class="card-title">${project.name}</h5> 
                          <p class="card-text">Руководитель проекта: ${project.manager}</p> 
                          <p class="card-text">Описание: ${project.description}</p> 
                          <p class="card-text">Дата начала: ${formatDate(project.date_start)}</p> 
                          <p class="card-text">Дата окончания: ${formatDate(project.date_end)}</p> 
                          <h4>Задачи:</h4> 
                          <div class="card border-success mb-3" style="max-width: 18rem;">
<div class="card-header">Задачи проекта</div> 
                              <div class="card-body">${tasksHtml}</div> 
                          </div> 
                          <p class="card-text">Статус: ${project.status}</p> 
                          <a href="adminUpdateProject.html?id=${project.id}" class="btn btn-success">Изменить</a> 
                      </div> 
                  </div> 
              `; 

              container.append(card); 
          }); 
      }, 
      error: function (xhr, status, error) { 
          console.error('Error:', error); 
          alert('Ошибка при загрузке данных проектов.'); 
      } 
  }); 

  // Функция для форматирования дат в русском формате 
  function formatDate(dateString) { 
      const date = new Date(dateString); 
      const day = date.getDate().toString().padStart(2, '0'); 
      const month = (date.getMonth() + 1).toString().padStart(2, '0'); 
      const year = date.getFullYear(); 
      return `${day}.${month}.${year}`; 
  } 
});