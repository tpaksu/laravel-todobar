@for ($i = 0; $i < 10; $i++)
<li class="{{$i % 2 == 0 ? 'custom-checkbox-odd' : ''}}">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="todobar-task-{{$i}}">
        <label class="custom-control-label" for="todobar-task-{{$i}}">Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Consectetur at itaque assumenda officia et quod modi aliquam? Autem nihil voluptate laboriosam, ipsa
            provident, corrupti, repellat possimus quos sunt ex dolore?</label>
    </div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary" onclick="todobar.tasks.edit('project_id', 'task_id');">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="todobar.tasks.delete('project_id', 'task_id');">Delete</button>
    </div>
</li>
@endfor
