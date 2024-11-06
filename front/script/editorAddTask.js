$(document).ready(function () {
    var strGET = window.location.search.replace('?', '');
    var projectId = strGET.slice(3);

    $.ajax({
        url: `http://manage-back/taskAdd/${projectId}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#tasks-container').empty();

           $.each(data.tasks, function (index, tasks) {
    let card = `
        <form action="" method="post" >
            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Приоритет</label>
                <select class="form-select" id="priority" name="priority" required>
                    <option value="">Выберите приоритет</option>
                    <option value="Низкий">Низкий</option>
                    <option value="Средний">Средний</option>
                    <option value="Высокий">Высокий</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="date_start" class="form-label">Дата начала</label>
                <input type="date" class="form-control" id="date_start" name="date_start" required>
            </div>
            <div class="mb-3">
                <label for="date_end" class="form-label">Дата окончания</label>
                <input type="date" class="form-control" id="date_end" name="date_end" required>
            </div>
            <div class="mb-3">
                <label for="manager" class="form-label">Исполнитель</label>
                <select class="form-select" id="manager" name="id_manager" required>
                    <option value="">Выберите исполнителя</option>
                    ${data.editors.map(editor => `<option value="${editor.id}">${editor.name}</option>`).join('')}
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Создать задачу</button>
        </form>
    `;
    
    $('#tasks-container').append(card); // Добавляем форму в контейнер
});
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('Ошибка при загрузке задач.');
        }
    });

    // Функция для форматирования дат
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString();
    }
});


