<div class="laravel-todobar">
    <div class="laravel-todobar-handle" onclick="document.querySelector('html').classList.toggle('todobar-active')">TodoBar</div>
    @include('laravel-todobar::partials.projects')
    <div class="laravel-todobar-content">
        <h3>Tasks</h3>
        <ul class="laravel-todobar-list">
            <li><input type="checkbox">&nbsp;Task #1</li>
            <li><input type="checkbox">&nbsp;Task #2</li>
            <li><input type="checkbox">&nbsp;Task #3</li>
            <li><input type="checkbox">&nbsp;Task #4</li>
            <li>@include("laravel-todobar::partials.form")</li>
        </ul>
    </div>
</div>
