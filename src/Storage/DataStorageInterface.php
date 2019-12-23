<?php

namespace TPaksu\TodoBar\Storage;

interface DataStorageInterface {
    public function all();
    public function find($id);
    public function insert($values);
    public function update($id, $values);
    public function delete($id);
}
