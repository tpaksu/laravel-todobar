<div class="todobar-projects-container">
    <select class="custom-select custom-select-sm todobar-projects-select" onchange="todobar.projects.input_changed(this);">
        <option value="-1">Select a Project</option>
    </select>
    <button type="button" class="btn btn-sm btn-primary" onclick="todobar.projects.add()">Add</button>
    <button type="button" class="btn btn-sm btn-secondary" onclick="todobar.projects.edit()">Ren</button>
    <button type="button" class="btn btn-sm btn-danger" onclick="todobar.projects.delete()">Del</button>
</div>
