const userId = sessionStorage.getItem("id");
let currentPage = 1;
let currentPriority = '';

// Функция для загрузки задач
function fetchTasks(page = 1, priority = '') {
    $.ajax({
        url: 'http://manage-back/userAllTask',
        type: 'GET',
        data: { user_id: userId, page: page, priority: priority },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            let container = $('.project-container');
            container.empty();

            $.each(data.data, function (index, task) { 
                  // подсчет остатка дней 
                  const dateEnd = new Date(task.date_end);
                  const dateStart = new Date(task.date_start);
                  const diffDays = Math.ceil((dateEnd - new Date()) / (1000 * 60 * 60 * 24));
                  const daysLeft = diffDays < 0 ? 0 : diffDays;
                let statusOptions = '';

                // Проверяем статус задачи и формируем радиокнопки
            if (task.status !== 'Завершена') {
                statusOptions = `
                    <div class="form-check"> 
                        <input class="form-check-input" type="radio" name="status" value="Назначена" id="status1_${task.id}" ${task.status == 'Назначена' ? 'checked' : ''}> 
                        <label class="form-check-label" for="status1_${task.id}">Назначена</label> 
                    </div> 
                    <div class="form-check"> 
                        <input class="form-check-input" type="radio" name="status" value="Выполняется" id="status2_${task.id}" ${task.status == 'Выполняется' ? 'checked' : ''}> 
                        <label class="form-check-label" for="status2_${task.id}">Выполняется</label> 
                    </div> 
               ` ;
            } if (task.status === 'Выполняется') {
                statusOptions = `<input class="form-check-input" type="radio" name="status" value="Завершена" id="status3_${task.id}" ${task.status == 'Завершена' ? 'checked' : ''}> 
                        <label class="form-check-label" for="status2_${task.id}">Завершить</label> `;
            }

                let card = `
                    <div class="card border-success mb-3" style="max-width: 18rem;"> 
                        <div class="card-body"> 
                            <h5 class="card-title">Название: ${task.name}</h5> 
                            <p class="card-text">Описание: ${task.description}</p> 
                            <p class="card-text">Дата начала: ${formatDate(task.date_start)}</p> 
                            <p class="card-text">Дата окончания: ${formatDate(task.date_end)}</p> 
                                    <p class="card-text">До конца осталось: ${daysLeft } дней</p>

                        </div> 
                        <div class="card-footer text-body-secondary"> 
                            <form action="" method="POST" class="updateStatusForm" id="updateStatus_${task.id}">
                                <input type="hidden" name="taskId" value="${task.id}">
                                ${statusOptions}
                                ${task.status === 'Завершена' ? '<p>Статус: Завершена (изменение невозможно)</p>' : '<button type="submit" class="btn btn-primary">Сохранить статус</button>'}
                            </form> 
                            Приоритет: ${task.priority} 
                        </div> 
                        <div class="commentary">  
                            <p>Оставить комментарий</p> 
                            <button type="button" class="btn btn-primary add-comment-btn" data-bs-toggle="modal" data-bs-target="#commentModal" data-task-id="${task.id}"><img src="../images/icons8-комментарии-48.png" alt="" class="img-comment"></button>
                        </div> 
                    </div>`;
                    container.append(card);

                    $(`#updateStatus_${task.id}`).on('submit', function (e) {
                        e.preventDefault();
                    
                        console.log('Отправляемые данные:', $(this).serialize());
                    
                        $.ajax({
                            url: `http://manage-back/UserTasksUpdate/${task.id}`,
                            type: 'PATCH',
                            data: $(this).serialize(),
                            success: function (response) {
                                console.log('Задача успешно обновлена:', response);
                                alert('Изменения сохранены успешно!');
                                // Обновите задачи или перенаправьте
                                fetchTasks(currentPage, currentPriority);
                            },
                            error: function (xhr, status, error) {
                                console.error('Ошибка при обновлении задачи:', error);
                                console.error('Ответ сервера:', xhr.responseText);
                                alert('Произошла ошибка при сохранении изменений: ' + xhr.responseText);
                            }
                        });
                });
            });
            // Получение комментариев для текущей задачи
    
            // Отображение пагинации
            displayPagination(data);
        },
        error: function (xhr, status, error) {
            console.error('Ошибка при загрузке задач:', error);
        }
        
    });
    
}
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU');
}
// Функция для отображения пагинации
function displayPagination(data) {
    const paginationContainer = $('.pagination-container');
    paginationContainer.empty();
    for (let i = 1; i <= data.last_page; i++) {
        const pageItem = `<button class="page-item ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
        paginationContainer.append(pageItem);
    }
}

// Обработчик клика по страницам
$(document).on('click', '.page-item', function () {
    currentPage = $(this).data('page');
    fetchTasks(currentPage, currentPriority);
});

// Фильтрация по приоритету
$(document).on('change', '#priorityFilter', function () {
    currentPriority = $(this).val();
    currentPage = 1; // Сбрасываем на первую страницу
    fetchTasks(currentPage, currentPriority);
});

// Инициализация
$(document).ready(function () {
    fetchTasks();
});

// Обработчик отправки формы комментария
$(document).on('submit', '#commentForm', function (e) {
    e.preventDefault();
    const commentContent = $('#commentText').val();
    const taskId = $('#modalTaskId').val();

    if (commentContent) {
        $.ajax({
            url: 'http://manage-back/createComment',
            type: 'POST',
            dataType: 'json',
            data: {
                content: commentContent,
                taskId: taskId,
                userId: userId
            },
            success: function (response) {
                console.log('Комментарий успешно добавлен:', response);
                alert('Комментарий добавлен!');
                $('#commentModal').modal('hide');
                $('#commentText').val('');
            },
            error: function (xhr, status, error) {
                console.error('Ошибка при добавлении комментария:', error);
                alert(`Не удалось добавить комментарий: ${xhr.responseText}`);
            }
        });
    }
});

// Запоминаем taskId при открытии модального окна
$(document).on('click', '.add-comment-btn', function () {
    const taskId = $(this).data('task-id');
    $('#modalTaskId').val(taskId);
});

// Модальное окно для комментария
let modalHTML = `
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Оставить комментарий</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="commentForm" method="post">
                        <div class="mb-3">
                            <label for="commentText" class="form-label">Комментарий</label>
                            <textarea class="form-control" id="commentText" name="content"></textarea>
                        </div>
                        <input type="hidden" id="modalTaskId" value="">
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>`;
$('body').append(modalHTML);
