<?php

namespace TPaksu\TodoBar\Storage;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class JSONStorage implements DataStorageInterface
{
    protected $client = null;
    protected $json = null;
    protected $file = null;

    public function __construct($file)
    {
        $this->file = $file;
        $this->client = Storage::createLocalDriver(['root' => resource_path("/todobar")]);

        if($this->client->exists($file) === false) $this->client->put($file, "{\"projects\": []}");
        $this->json = json_decode($this->client->get($file));
    }

    public function all()
    {
        return $this->json->projects;
    }

    public function find($id)
    {
        return $this->json->projects[$id];
    }

    public function insert($values)
    {
        // reorder indexes
        $this->json->projects = array_values($this->json->projects);

        // get the new index
        $id = count($this->json->projects);

        // store new item
        $this->json->projects[$id] = [
            "id" => $id,
            "name" => $values["name"],
            "items" => []
        ];
        // update the file
        $this->updateStorage();

        // return newly added id
        return $id;
    }

    public function update($id, $values)
    {
        $this->json->projects[$id]->name = $values["name"];
        $this->updateStorage();
    }

    public function delete($id)
    {
        unset($this->json->projects[$id]);

        // reorder indexes
        $this->json->projects = array_values($this->json->projects);

        // update the file
        $this->updateStorage();
    }

    protected function updateStorage()
    {
        $this->client->put($this->file, json_encode($this->json));
    }
}
