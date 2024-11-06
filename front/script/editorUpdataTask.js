$(document).ready(function() { 
    var strGET = window.location.search.replace('?', '');  
    var taskId = strGET.slice(3);  

    $.ajax({ 
        url: `http://manage-back/taskEdit/${taskId}`, 
        type: 'GET', 
        dataType: 'json', 
        success: function(data) { 
            let form = ` 
                <form id="saving_changes" method="POST"> 
                    <div class="card" style="width: 100%;"> 
                        <div class="card-body">     
                            <div class="form-group"> 
                                <label for="taskName">Название</label> 
                                <input type="text" class="form-control" id="taskName" name="name" value="${data.task.name}" required> 
                            </div> 
                            <div class="form-group"> 
                                <label for="taskDescription">Описание</label> 
                                <textarea class="form-control" id="taskDescription" name="description">${data.task.description}</textarea> 
                            </div> 
                            <div class="form-group"> 
                                <label for="taskDateStart">Дата начала</label> 
                                <input type="date" class="form-control" id="taskDateStart" name="date_start" value="${data.task.date_start}"> 
                            </div> 
                            <div class="form-group"> 
                                <label for="taskDateEnd">Дата окончания</label> 
                                <input type="date" class="form-control" id="taskDateEnd" name="date_end" value="${data.task.date_end}"> 
                            </div> 
                            <div class="form-group"> 
                                <label for="taskPriority">Приоритет</label> 
                                <select class="form-control" id="taskPriority" name="priority"> 
                                    <option value="Низкий" ${data.task.priority === 'Низкий' ? 'selected' : ''}>Низкий</option> 
                                    <option value="Средний" ${data.task.priority === 'Средний' ? 'selected' : ''}>Средний</option> 
                                    <option value="Высокий" ${data.task.priority === 'Высокий' ? 'selected' : ''}>Высокий</option> 
                                </select> 
                            </div> 
                            <div class="form-group"> 
                                <label for="taskStatus">Статус</label> 
                                <select class="form-control" id="taskStatus" name="status"> 
                                    <option value="Назначена" ${data.task.status === 'Назначена' ? 'selected' : ''}>Назначена</option> 
                                    <option value="Выполняется" ${data.task.status === 'Выполняется' ? 'selected' : ''}>Выполняется</option> 
                                    <option value="Завершена" ${data.task.status === 'Завершена' ? 'selected' : ''}>Завершена</option> 
                                </select> 
                            </div> 
                            <div class="form-group"> 
                                <label for="taskEditor">Исполнитель</label> 
                                <select class="form-control" id="taskEditor" name="id_user"> 
                                    ${data.editors.map(editor => `<option value="${editor.id}" ${data.task.editorId === editor.id ? 'selected' : ''}>${editor.name}</option>`).join('')} 
                                </select> 
                            </div> 
                        </div>     
                        <div class="card-body">     
                            <button type="submit" class="btn btn-success">Сохранить изменения</button>     
                        </div>
</div>     
                </form> 
            `; 

            $('.container').html(form);  

            $('#saving_changes').on('submit', function(e) {
                e.preventDefault(); // Предотвращаем стандартное поведение формы

                $.ajax({
                     url: `http://manage-back/taskEditUpdate/${taskId}`, 
                    type: 'POST',
                    data: $(this).serialize(), 
                    success: function(response) {
                        console.log('Задача успешно обновлена:', response);
                        alert('Изменения сохранены успешно!');
                        location.href = "../editor/editorIndex.html";
                    },
                    error: function(xhr, status, error) {
                        console.error('Ошибка при обновлении задачи:', error);
                        alert('Ошибка при сохранении изменений: ' + error);
                    }
                });
            });
            
        },
        error: function(xhr, status, error) {
            console.error('Ошибка при загрузке задачи:', error);
            alert('Произошла ошибка при загрузке задачи. Попробуйте еще раз.');
        }
    });
});