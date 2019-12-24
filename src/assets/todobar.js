let todobar = {
    active_project: null,
    init: function () {
        todobar.projects.init();
    },
    projects: {
        init: function () {
            todobar.projects.get(todobar.utils.remember());
        },
        input_changed: function (input) {
            todobar.active_project = input.value;
            todobar.utils.memorize();
            todobar.tasks.get(todobar.active_project);
        },
        get: function (initial) {
            let projects_select = document.querySelector(".todobar-projects-select");
            todobar.fetcher.get("projects", (result) => {
                let options = "<option value='-1'>Select a Project</option>";
                result.data.forEach((element, key) => {
                    options += "<option value='" + key + "'>" + element + "</option>";
                });
                projects_select.innerHTML = options;
                projects_select.value = (initial == undefined || initial == null) ? -1 : initial;
                projects_select.dispatchEvent(new Event("change"));
            });
        },
        add: function () {
            let project_name = prompt("What will be the new project's name?");
            if (project_name != null) {
                todobar.fetcher.post("projects", {
                    name: project_name
                }, (result) => {
                    todobar.projects.get(parseInt(result.id, 10));
                });
            }
        },
        edit: function () {
            let selected_item = document.querySelector(".todobar-projects-select ").selectedOptions[0],
                project_name = selected_item.text,
                project_id = selected_item.value;
            if (project_id && project_id >= 0) {
                let new_project_name = prompt("What will be the new project name?", project_name);
                if (new_project_name !== null) {
                    todobar.fetcher.patch("projects/" + project_id, {
                        name: new_project_name
                    }, (result) => {
                        if (result.status == "success") {
                            todobar.projects.get(parseInt(project_id, 10));
                        } else if (result.status == "error") {
                            alert(result.error);
                        }
                    });
                }
            } else {
                alert("You need to select a project first to change it's name!");
            }
        },
        delete: function () {
            let selected_item = document.querySelector(".todobar-projects-select ").selectedOptions[0], project_id = selected_item.value;
            if (project_id && project_id >= 0) {
                if (confirm("Are you sure to delete this project? This will also remove all associated tasks. And can't be undone. Are you still sure?")) {
                    todobar.fetcher.delete("projects/"+project_id, (result) => {
                        if (result.status == "success") {
                            todobar.projects.get();
                        } else if (result.status == "error") {
                            alert(result.error);
                        }
                    });
                }
            } else {
                alert("You need to select a project first to delete it!");
            }
        }
    },
    tasks: {
        get: function (project_id) {
            todobar.fetcher.get("/projects/" + project_id + "/tasks", function (result) {
                if (result.status == "success") {
                    document.querySelector(".laravel-todobar-list").innerHTML = result.html;
                } else if (result.status == "error") {
                    alert(result.error);
                }
            });
        },
        add: function () {
            let project_id = todobar.active_project, task = document.querySelector("#laravel-task-input").value;
            todobar.fetcher.post("/projects/" + project_id + "/tasks", {
                content: task
            }, function (result) {
                if (result.status == "success") {
                    todobar.tasks.get(project_id);
                } else if (result.status == "error") {
                    alert(result.error);
                }
            });
        },
        edit: function (project_id, task_id, task) {
            todobar.fetcher.patch("/projects/" + project_id + "/tasks/" + task_id, {
                task: task
            }, function (result) {
                if (result.status == "success") {
                    todobar.tasks.get(project_id);
                } else if (result.status == "error") {
                    alert(result.error);
                }
            });
        },
        delete: function (project_id, task_id) {
            todobar.fetcher.delete("/projects/" + project_id + "/tasks/" + task_id, function (result) {
                if (result.status == "success") {
                    todobar.tasks.get(project_id);
                } else if (result.status == "error") {
                    alert(result.error);
                }
            });
        },
        setStatus: function (project_id, task_id, completed) {
            todobar.fetcher.patch("/projects/" + project_id + "/tasks/" + task_id, {status: completed}, function (result) {
                if (result.status == "success") {
                    todobar.tasks.get(project_id);
                } else if (result.status == "error") {
                    alert(result.error);
                }
            });
        }
    },
    fetcher: {
        get: function (endpoint, callback) {
            this.fetch("GET", endpoint, undefined, callback);
        },
        delete: function (endpoint, callback) {
            this.fetch("DELETE", endpoint, undefined, callback);
        },
        post: function (endpoint, data, callback) {
            this.fetch("POST", endpoint, data, callback);
        },
        patch: function (endpoint, data, callback) {
            this.fetch("PATCH", endpoint, data, callback);
        },
        fetch: function (method, endpoint, data, callback) {
            todobar.utils.show_loader();
            fetch("/laravel-todobar/" + todobar.utils.trim_leading_slashes(endpoint), {
                    method: method,
                    headers: {
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + document.querySelector(".laravel-todobar input[name='todobar-token']").value
                    },
                    body: (data !== undefined) ? JSON.stringify(data) : null
                }).then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    alert(`Request failed: ${error}`)
                }).then((result) => {
                    if (result) {
                        callback(result);
                    }
                }).finally(() => {
                    todobar.utils.hide_loader();
                });
        }
    },
    utils: {
        trim_leading_slashes: function (str) {
            return str.replace(/^\/+/g, '');
        },
        show_loader: () => {
            if(document.querySelectorAll(".laravel-todobar-loader").length == 0){
                document.querySelector(".laravel-todobar-list").insertAdjacentHTML("afterend", '<div class="laravel-todobar-loader"> \
                    <svg width="135" height="135" viewBox="0 0 135 135" xmlns="http://www.w3.org/2000/svg" fill="#ddd"> \
                        <path d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z"> \
                            <animateTransform \
                                attributeName="transform" \
                                type="rotate" \
                                from="0 67 67" \
                                to="-360 67 67" \
                                dur="2.5s" \
                                repeatCount="indefinite"/> \
                        </path> \
                        <path d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z"> \
                            <animateTransform \
                                attributeName="transform" \
                                type="rotate" \
                                from="0 67 67" \
                                to="360 67 67" \
                                dur="8s" \
                                repeatCount="indefinite"/> \
                        </path> \
                    </svg> \
                </div>');
            }
        },
        hide_loader: () => {
            if(document.querySelectorAll(".laravel-todobar-loader").length > 0){
                document.querySelectorAll(".laravel-todobar-loader").forEach((item) => {
                    item.remove();
                });
            }
        },
        memorize: function () {
            window.localStorage.setItem("laravel-todobar-last-project", parseInt(todobar.active_project, 10));
        },
        remember: function () {
            return window.localStorage.getItem("laravel-todobar-last-project");
        }
    }
};

todobar.init();
