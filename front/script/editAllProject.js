$(document).ready(function() {
    // Извлекаем id пользователя из sessionStorage
    const userId = sessionStorage.getItem("id");

    $.ajax({
        url: 'http://manage-back/allProject',
        type: 'GET',
        data: { user_id: userId }, // Передаем user_id как параметр запроса
        dataType: 'json',
        success: function(data) {
            let container = $('.project-container');
            container.empty();

            if (!Array.isArray(data) || data.length === 0) {
                container.html('<p>У вас нет проектов или произошла ошибка загрузки данных.</p>');
                return;
            }

            // Создание карточек для каждого проекта
            $.each(data, function(index, project) {
                         // подсчет остатка дней 
                         const dateEnd = new Date(project.date_end);
                         const dateStart = new Date(project.date_start);
                         const diffDays = Math.ceil((dateEnd - new Date()) / (1000 * 60 * 60 * 24));
                         const daysLeft = diffDays < 0 ? 0 : diffDays;

                let card = `
                    <div class="card mb-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">${project.name}</h5>
                            <p class="card-text">Описание: ${project.description}</p>
                            <p class="card-text">Дата начала: ${formatDate(project.date_start)}</p>
                            <p class="card-text">Дата окончания: ${formatDate(project.date_end)}</p>
                            <p class="card-text">До конца осталось: ${daysLeft} дней</p>

                            <h4>Задачи:</h4>
                            <a href="InfoTaskProject.html?id=${project.id}" class="btn btn-secondary">Посмотреть все задачи</a>
                            <p class="card-text">Статус: ${project.status}</p>
                            <a href="editotUpdateProject.html?id=${project.id}" class="btn btn-success">Изменить</a>
                            <button type="button" class="btn btn-danger delete-task" data-project-id="${project.id}">Удалить</button>
                        </div>
                    </div>
                `;
                container.append(card);
            });

            // Привязываем обработчик к кнопкам удаления
            $('.delete-task').on('click', deleteTask);
        },
        error: function(xhr, status, error) {
            console.error('Ошибка AJAX:', error);
            alert('Ошибка при загрузке данных проектов.');
        }
    });

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('ru-RU');
    }

    // Обработчик для кнопки удаления задачи
    function deleteTask() {
        var projectId = $(this).data('project-id'); // Получаем projectId

        if (confirm('Вы уверены, что хотите удалить этот проект?')) {
            $.ajax({
                url: `http://manage-back/project/${projectId}`, // Убедитесь, что URL правильный
                type: 'DELETE',
                dataType: 'json',
                success: function() {
                    alert('Проект успешно удален!');
                    // Можно обновить список проектов или удалить карточку из DOM
                    $(this).closest('.card').remove(); // Удаляем карточку проекта
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при удалении проекта:', error);
                    alert('Не удалось удалить проект. Попробуйте еще раз.');
                }
            });
        }
    }
});
