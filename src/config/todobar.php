<?php

return [
    "enabled" => env("TODOBAR_ENABLED", true),
    "start_visible" => true,
    "overlay" => true,
    "dark_mode" => false,
    "storage" => [
        "engine" => \TPaksu\TodoBar\Storage\JSONStorage::class,
        "params" => [
            "file" => "items.json",
        ],
    ],
];
