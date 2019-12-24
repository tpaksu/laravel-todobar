@isset($tasks)
@forelse($tasks as $task)
<li class="{{$loop->index % 2 == 0 ? 'custom-checkbox-odd' : ''}}">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="todobar-task-{{$loop->index}}"
        @if($task->completed ?? false) checked @endif>
        <label class="custom-control-label" for="todobar-task-{{$loop->index}}"
            onclick="todobar.tasks.setStatus('{{$project_id}}', '{{$loop->index}}', document.querySelector('#' + this.getAttribute('for')).checked ? false : true);">
            {{$task->content}}
        </label>
    </div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary"
            onclick="todobar.tasks.edit('{{$project_id}}', '{{$loop->index}}');">Edit</button>
        <button class="btn btn-sm btn-danger"
            onclick="todobar.tasks.delete('{{$project_id}}', '{{$loop->index}}');">Delete</button>
    </div>
</li>
@empty
<li>
    This project is empty. Start with adding some tasks to it!
</li>
@endforelse
@endisset
@if(!isset($tasks))
<li>
    Please select a project from the upper list to start.
</li>
@endif
