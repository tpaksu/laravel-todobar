<?php

namespace TPaksu\TodoBar\Storage;

use Illuminate\Support\Facades\Storage;

class JSONStorage implements DataStorageInterface
{
    protected $client = null;
    protected $json = null;
    protected $file = null;

    public function __construct($params)
    {
        $this->file = $params["file"];
        $this->client = Storage::createLocalDriver(['root' => resource_path("/todobar")]);

        if ($this->client->exists($this->file) === false) {
            $this->client->put($this->file, "{\"projects\": []}");
        }

        $this->json = json_decode($this->client->get($this->file));
    }

    public function all()
    {
        return $this->json->projects;
    }

    public function find($id)
    {
        return $this->json->projects[$id] ?? null;
    }

    public function insert($values)
    {
        // reorder indexes
        $this->json->projects = array_values($this->json->projects);

        // get the new index
        $id = count($this->json->projects);

        // store new item
        $this->json->projects[$id] = new \stdClass();

        foreach ($values as $key => $value) {
            $this->json->projects[$id]->{$key} = $value;
        }
        // update the file
        $this->updateStorage();

        // return newly added id
        return $id;
    }

    public function update($id, $values)
    {
        if (isset($this->json->projects[$id])) {
            foreach ($values as $key => $value) {
                $this->json->projects[$id]->{$key} = $value;
            }
            $this->updateStorage();
        }
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
