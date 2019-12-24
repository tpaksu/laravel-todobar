<div class="laravel-todobar">
    <input type="hidden" name="todobar-token" value="{{csrf_token()}}">
    <div class="laravel-todobar-handle" onclick="document.querySelector('html').classList.toggle('todobar-active')">@include("laravel-todobar::partials.handle")</div>
    <div class="laravel-todobar-container">
        @include('laravel-todobar::partials.projects')
        <div class="laravel-todobar-content">
            <h3>Tasks</h3>
            <ul class="laravel-todobar-list">
                @include("laravel-todobar::partials.tasks")
            </ul>
            @include("laravel-todobar::partials.form")
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
