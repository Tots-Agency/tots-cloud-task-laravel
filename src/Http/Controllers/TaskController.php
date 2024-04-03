<?php

namespace Tots\CloudTask\Http\Controllers;

use Illuminate\Http\Request;
use Tots\CloudTask\Http\Requests\StoreRequest;
use Tots\CloudTask\Services\TaskService;

class TaskController extends \Illuminate\Routing\Controller
{
    /**
     *
     * @var TaskService
     */
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function handle(StoreRequest $request)
    {
        // Validate is Secret key is correct
        if (!$this->service->isValidSecretKey($request->input('secret_key'))) {
            throw new \Exception('The secret key is incorrect');
        }
        // Get Task Class Name
        $taskName = $request->input('tots_task_name');
        // Create Task
        $task = new $taskName();
        // Run Task
        $task->run($request->all());
        // Return
        return response()->json(['success' => true]);
    }
}