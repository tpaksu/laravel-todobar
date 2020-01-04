<?php

namespace TPaksu\TodoBar\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TPaksu\TodoBar\Storage\DataStorageInterface;

class TodoBarTasks extends Controller
{
    protected $storage;

    public function __construct(DataStorageInterface $storage)
    {
        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $project_id)
    {
        if ($project_id >= 0) {
            $project = $this->storage->find($project_id) ?? null;
            if ($project) {
                return response()->json([
                    "status" => "success",
                    "project" => $project,
                    "html" => view()->make('laravel-todobar::partials.tasks', ["tasks" => $project->tasks, "project_id" => $project_id])->render(),
                ], 200);
            }
            return response()->json(["status" => "error", "error" => "Sorry, we can't find the project with that ID."]);
        } else {
            return response()->json([
                "status" => "success",
                "project" => null,
                "html" => view()->make('laravel-todobar::partials.tasks')->render(),
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id)
    {
        $request->validate([
            "content" => "required|string|filled",
        ]);

        $project = $this->storage->find($project_id);

        if ($project) {
            $project->tasks[] = (object)[
                "content" => $request->content,
                "completed" => 0,
            ];
            $this->storage->update($project_id, $project);
            return response()->json(["status" => "success"], 200);
        } else {
            return response()->json(["status" => "error", "error" => "We couldn't find the project that you wanted to add that task."], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id, $task_id)
    {
        if ($request->has("status")) {
            $request->validate([
                "status" => "required|boolean"
            ]);
            $update = "completed";
            $update_key = "status";
        } else {
            $request->validate([
                "content" => "required|string|filled",
            ]);
            $update = "content";
            $update_key = "content";
        }

        $project = $this->storage->find($project_id);

        if ($project) {
            if (isset($project->tasks[$task_id])) {

                $project->tasks[$task_id]->{$update} = $request->get($update_key);

                $this->storage->update($project_id, $project);
                return response()->json(["status" => "success"], 200);
            } else {
                return response()->json(["status" => "error", "error" => "We couldn't find the task that you wanted to update."], 200);
            }
        } else {
            return response()->json(["status" => "error", "error" => "We couldn't find the project that you wanted to add that task."], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $task_id)
    {
        $project = $this->storage->find($project_id);

        if ($project) {
            if (isset($project->tasks[$task_id])) {
                unset($project->tasks[$task_id]);
                $project->tasks = array_values($project->tasks);
                $this->storage->update($project_id, $project);
                return response()->json(["status" => "success"], 200);
            } else {
                return response()->json(["status" => "error", "error" => "We couldn't find the task that you wanted to update."], 200);
            }
        } else {
            return response()->json(["status" => "error", "error" => "We couldn't find the project that you wanted to add that task."], 200);
        }
    }
}
