@isset($tasks)
@forelse($tasks as $key => $task)
<li class="laravel-todobar-task {{$loop->index % 2 == 0 ? 'custom-checkbox-even' : 'custom-checkbox-odd'}}">
    <div class="form-group">
        <input type="checkbox" id="todobar-task-{{$key}}" @if($task->completed ?? false) checked @endif
        onclick="todobar.tasks.setStatus('{{$project_id}}', '{{$key}}', document.querySelector('#' + this.id).checked);">
        <label>
            <div class="checkbox-dummy" onclick="var checkbox = document.querySelector('#todobar-task-{{$key}}'); checkbox.checked = !checkbox.checked; checkbox.dispatchEvent(new Event('click'));">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11pt" height="11pt" viewBox="0 0 16 13" version="1.1">
                    <g id="surface1">
                        <path style=" stroke:none;fill-rule:nonzero;fill:white;fill-opacity:1;" d="M 5.96875 12.878906 L 0 6.90625 L 2.847656 4.058594 L 5.96875 7.179688 L 13.152344 0 L 16 2.847656 Z M 5.96875 12.878906 "/>
                    </g>
                </svg>
            </div>
            <div class="label-content">
                {{$task->content}}
            </div>
        </label>
    </div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary"
            onclick="todobar.tasks.edit_form('{{$project_id}}', '{{$key}}', '{{$task->content}}');">Edit</button>
        <button class="btn btn-sm btn-danger"
            onclick="todobar.tasks.delete('{{$project_id}}', '{{$key}}');">Delete</button>
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
