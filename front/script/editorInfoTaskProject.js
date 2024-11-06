$(document).ready(function () {
    var strGET = window.location.search.replace('?', '');
    var projectId = strGET.slice(3);

    function fetchTasks(priority = '') {
        $.ajax({
            url: `http://manage-back/projects/${projectId}/tasks`,
            type: 'GET',
            data: { priority: priority }, // Передаем выбранный приоритет
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#tasks-container').empty();
                
                $.each(data.tasks.data, function(index, task) {
                          // подсчет остатка дней 
                          const dateEnd = new Date(task.date_end);
                          const dateStart = new Date(task.date_start);
                          const diffDays = Math.ceil((dateEnd - new Date()) / (1000 * 60 * 60 * 24));
                          const daysLeft = diffDays < 0 ? 0 : diffDays;
                    let card = `
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Название:${task.name}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Описание: ${task.description}</p>
                                     <p class="card-text">Исполнитель: ${task.user ? task.user.name : 'Не назначен'}</p>
                                    <p class="card-text">Дата начала: ${formatDate(task.date_start)}</p>
                                    <p class="card-text">Дата окончания: ${formatDate(task.date_end)}</p>
                                    <p class="card-text">До конца осталось: ${daysLeft } дней</p>
                                    <!-- Добавляем комментарии -->
                                    <div class="comments">
                                        <h6>Комментарии:</h6>
                                        ${task.comment.length > 0 ? 
                                            task.comment.map(comment => `
                                                <div class="card">
                                                    <p><strong>${comment.user.name}:</strong> ${comment.content}</p>
                                                    <p>Дата:<em>${formatDate(comment.created_at)}</em></p>
                                                </div>
                                            `).join('') : 
                                            '<p>Нет комментариев</p>'
                                        }
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="editorUpdateTask.html?id=${task.id}" class="btn btn-success">Изменить</a>
                                    <button type="button" class="btn btn-danger delete-task" data-id="${task.id}" data-project-id="${projectId}">Удалить</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#tasks-container').append($(card));
                });

                // Пагинация
                setupPagination(data.tasks);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('Ошибка при загрузке задач.');
            }
        });
    }

    // Функция для установки пагинации
    function setupPagination(tasks) {
        $('.pagination-container').empty();
        for (let i = 1; i <= tasks.last_page; i++) {
            let pageLink = `<a href="#" class="page-link" data-page="${i}" style ="width:30px">${i}</a>`;
            $('.pagination-container').append(pageLink);
        }

        // Обработчик клика по ссылке страницы
        $('.page-link').on('click', function (e) {
            e.preventDefault();
            let page = $(this).data('page');
            fetchTasks($('#priorityFilter').val(), page);
        });
    }

    // Обработчик изменения фильтра приоритета
    $('#priorityFilter').change(function () {
        let priority = $(this).val();
        fetchTasks(priority);
    });

    // Изначальная загрузка задач
    fetchTasks();

    // Функция для форматирования дат
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString();
    }

    // Обработчик для кнопки удаления задачи
    $('#tasks-container').on('click', '.delete-task', function () {
        var taskId = $(this).data('id');
        var projectId = $(this).data('project-id');

        if (confirm('Вы уверены, что хотите удалить эту задачу?')) {
            $.ajax({
                url: `http://manage-back/task/${taskId}`,
                type: 'DELETE',
                dataType: 'json',
                success: function () {
                    // Удаление карточки задачи из DOM
                    $(`.delete-task[data-id="${taskId}"]`).closest('.card').remove();
                    alert('Задача успешно удалена!');
                },
                error: function (xhr, status, error) {
                    console.error('Ошибка при удалении задачи:', error);
                    alert('Не удалось удалить задачу. Попробуйте еще раз.');
                }
            });
        }
    });

});
