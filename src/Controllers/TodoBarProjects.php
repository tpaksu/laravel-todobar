<?php

namespace TPaksu\TodoBar\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TPaksu\TodoBar\Storage\DataStorageInterface;

class TodoBarProjects extends Controller
{
    public function __construct(DataStorageInterface $storage)
    {
        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->storage->all();
        return response()->json(["status" => "success", "data" => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_id = $this->storage->insert([
            "name" => $request->name,
        ]);
        return response()->json(["status" => "success", "id" => $new_id, "name" => $request->name], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = $this->storage->find($id);
        return response()->json(["status" => "success", "tasks" => $tasks], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->storage->update($id, [
            "name" => $request->name,
        ]);
        return response()->json(["status" => "success", "id" => $id, "name" => $request->name], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->storage->delete($id);
        return response()->json(["status" => "success"], 200);
    }
}
