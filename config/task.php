<?php

return [
    'project_id' => env('CLOUD_TASK_PROJECT_ID', ''),
    'app_engine_service' => env('CLOUD_TASK_APP_ENGINE_SERVICE', ''),
    'location_id' => env('CLOUD_TASK_LOCATION_ID', ''),
    'queue_id' => env('CLOUD_TASK_QUEUE_ID', ''),
    'secret_key' => env('CLOUD_TASK_SECRET_KEY', ''),
    'is_active' => env('CLOUD_TASK_IS_ACTIVE', 0),
];