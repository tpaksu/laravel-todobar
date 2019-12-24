<div class="laravel-todobar">
    <input type="hidden" name="todobar-token" value="{{csrf_token()}}">
    <div class="laravel-todobar-handle" onclick="document.querySelector('html').classList.toggle('todobar-active')">@include("laravel-todobar::partials.handle")</div>
    <div class="laravel-todobar-container">
        @include('laravel-todobar::partials.projects')
        <div class="laravel-todobar-content">
            <h3>Tasks</h3>
            @include("laravel-todobar::partials.form")
            <ul class="laravel-todobar-list">
                @include("laravel-todobar::partials.tasks")
            </ul>
        </div>
    </div>
</div>
<div id="laravel-todobar-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="laravel-todobar-edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="laravel-todobar-edit-modal">Edit Task</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id="laravel-todobar_project_id" name='laravel-todobar_project_id'>
                <input type='hidden' id="laravel-todobar_task_id" name='laravel-todobar_task_id'>
                <textarea id="laravel-todobar_content" class="form-control" style="min-width: 100%" rows=6 name="laravel-todobar_content"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="todobar.tasks.edit()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@if(config("todobar.start_visible"))
<script>
    document.querySelector(".laravel-todobar-handle").dispatchEvent(new Event("click"));
</script>
@endif
@if(!config('todobar.overlay'))
<script>
    document.body.classList.add('laravel-todobar-split');
</script>
@endif
