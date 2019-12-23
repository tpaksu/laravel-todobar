let todobar = {
    init: function(){
        todobar.projects.init();
    },
    tasks: {
        get: function(project_id){

        },
        add: function(){

        },
        edit: function(){

        },
        delete: function(){

        }
    },
    projects: {
        init: function(){
            todobar.projects.get();
        },
        get: function(){
            todobar.fetcher.get("projects", (result) => {
                let options = "<option value>Select a Project</option>";
                result.data.forEach(element => {
                    options += "<option value='"+element.id+"'>"+element.name+"</option>";
                });
                document.querySelector(".todobar-projects-select").innerHTML = options;
            });
        },
        add: function(sender){
            let project_name = prompt("What will be the new project's name?");
            if(project_name != null){
                todobar.fetcher.post("projects", {
                    name: project_name
                }, (result) => {
                    todobar.projects.get();
                });
            }
        },
        edit: function(id){
            let selected_item = document.querySelector(".todobar-projects-select ").selectedOptions[0], project_name = selected_item.text, project_id = selected_item.value;
            if(project_id){
                let new_project_name = prompt("What will be the new project name?", project_name);
                if(new_project_name !== null){
                    todobar.fetcher.patch("projects/"+project_id, {
                        name: new_project_name
                    }, (result) => {
                        todobar.projects.get();
                    });
                }
            }else{
                alert("You need to select a project");
            }
        },
        delete: function(){

        },
        memorize: function(){

        },
        remember: function(){

        }
    },
    fetcher: {
        get: function(endpoint, callback){
            this.fetch("GET", endpoint, undefined, callback);
        },
        delete: function(endpoint, callback){
            this.fetch("DELETE", endpoint, undefined, callback);
        },
        post: function(endpoint, data, callback){
            this.fetch("POST", endpoint, data, callback);
        },
        patch: function(endpoint, data, callback){
            this.fetch("PATCH", endpoint, data, callback);
        },
        fetch: function(method, endpoint, data, callback){
            fetch("/laravel-todobar/" + endpoint, {
                method: method,
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + document.querySelector(".laravel-todobar input[name='todobar-token']").value
                },
                body: (data !== undefined) ? JSON.stringify(data) : null
            }).then((response) => {
                if(!response.ok){
                    throw response.error;
                }
                return response.json()
            }).catch((error) => {
                alert(error.message);
            }).then((result) => {
                callback(result);
            });
        }
    }
};

todobar.init();
