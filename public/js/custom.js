/**
 * Initializes first Pikaday field
 *
 */
let picker = new Pikaday({
    field: document.getElementById('deadline1'),
    format: 'MM-DD-YYYY',
    toString(date, format) {
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        return `${year}-${month}-${day}`;
    },
    minDate: moment().toDate()
});

var x = 0;
var addButton = $('#addTask');
var wrapper = $('#fieldWrapper');

/**
 * Adds input fields for a new task
 *
 */
function addNewTask(startId=0){
    let x = startId;
    x++; //Increment field counter
    while ( $( '#task'+x+'name' ).length ) {
        x++;
    }
    let fieldHTML = '<div class="mt-4"><label for="task'+x+'Name">Task '+x+' Name</label>';
    fieldHTML += '<input type="text"  class="form-control" name="tasks['+x+'][name]" id="task'+x+'name" aria-describedby="task'+x+'nameHelp" placeholder="Enter name for this task" required>';
    fieldHTML += '<small id="task'+x+'Help" class="form-text text-muted">Provide some meaningful name.</small>';
    fieldHTML += '<label for="task'+x+'Deadline">Task '+x+' Deadline</label>';
    fieldHTML += '<div class="input-group" >';
    fieldHTML += '<input type="text" name="tasks['+x+'][deadline]"  id="deadline'+x+'" class="form-control" placeholder="Pick a deadline"/>';
    fieldHTML += '</div>';
    fieldHTML += '<small id="tasks'+x+'DeadlineHelp" class="form-text text-muted">After this date the task will be inactive!</small>';

    fieldHTML += '<div class="form-check form-check-inline">';
    fieldHTML += '<input class="form-check-input" type="radio" name="tasks['+x+'][status]" id="enabled" value="active" checked>';
    fieldHTML += '<label clas="form-check-label" for="enabled">Active</label>';
    fieldHTML += '</div>';
    fieldHTML += '<div class="form-check form-check-inline">';
    fieldHTML += '<input class="form-check-input" type="radio" name="tasks['+x+'][status]" id="disabled" value="disabled">';
    fieldHTML += '<label class="form-check-label" for="disabled">Disabled</label>';
    fieldHTML += '</div>';

    fieldHTML += '<br /><p class="text-right"><a href="javascript:void(0);" class="removeTaskButton btn btn-danger" >Remove task</a></p></div>';
    $(wrapper).append(fieldHTML); //Add field html

    let picker = new Pikaday({
        field: document.getElementById('deadline'+x),
        toString(date, format) {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            return `${year}-${month}-${day}`;
        },
        minDate: moment().toDate()
    });


};

/**
 * Removes input fields added by jquery
 *
 */
$(wrapper).on('click', '.removeTaskButton', function(e){
    e.preventDefault();
    $(this).closest('div').remove();
    x--;

});

/**
 * Deletes a task (using ajax request)
 *
 */
$(wrapper).on('click', '.destroyTaskButton', function(e){
    let taskId = $(this).siblings('.taskId').val();
    $.ajax({
        type: "GET",
        dataType: "json",
        url: '/taskDestroy',
        data: {'taskId': taskId}
    });
});

/**
 * Changes a task's status (using ajax request)
 *
 */
$('.task-status').change(function() {
    let taskStatus = $(this).val();
    let taskId = $(this).attr('data-id');
    $('#response'+taskId).html('<span class="text-info">New status: saving...</span>');
    $.ajax({
        type: "GET",
        dataType: "json",
        url: '/taskChangeStatus',
        data: {'taskStatus': taskStatus, 'taskId': taskId},
        success: function(data){
            $('#response'+taskId).show();
            $('#response'+taskId).html('<span class="text-success">New status: saved!</span>').fadeOut(10000);
        }
    });
});
