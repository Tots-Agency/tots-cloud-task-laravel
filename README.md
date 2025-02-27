<div align="center">
<img src="https://raw.githubusercontent.com/Tots-Agency/tots-template-api/main/public/tots-icon.png?token=GHSAT0AAAAAACZTFJVOGUNKPIHUYNA3GUYIZ43Y6BA" alt="TOTS Logo"/>
<h3>
  Cloud Task Utility library (Laravel)
</h3>
</div>
<div align="center">
    <a href="#-getting-started">
        Getting Started
    </a>
    <span>&nbsp;✦&nbsp;</span>
    <a href="#-contact">
        Contact
    </a>
</div>

## 🛠️ Prerequisites

- SO: OSX, Linux, Windows with WSL2
- [**PHP 8.2**](https://php.net)
- [**Composer**](https://getcomposer.org)
- [**Laravel 11**](https://laravel.com/)

## 🧑‍💻 Getting Started

To start using this useful library and run Google cloud task, you need to follow the next steps:

1.  Open your `componser.json` and add the following repositories:

```json
  "repositories": [
    // other repositories
    {
        "type": "git",
        "url": "https://github.com/tots-agency/tots-cloud-task-laravel.git"
    },
    {
        "type": "git",
        "url": "https://github.com/tots-agency/tots-core-laravel.git"
    }
  ]
```

2. Add packages `tots/cloud-task-laravel` and `tots/core-laravel` to require object in `composer.json` file

```json

  "require": {
    // others packages
    "tots/core-laravel": "dev-main",
    "tots/cloud-task-laravel": "dev-main"
  }

```

3. Execute the following command to update your dependencies

```bash
  composer update
```

4. Create your task:
   You can create it directly in the google cloud console following the [next instruction](https://cloud.google.com/tasks/docs/creating-queues) or using the gcloud cli.
   If you choose gcloud cli, follow the [glocloud installation instruction](https://cloud.google.com/sdk/docs/install)
   Once you installed the cli, you need to follow the steps:

- Authenticate in gclod:

```bash
 gcloud auth login
```

- Create task

```bash
 gcloud tasks queues create [QUEUE_ID_OR_NAME] //if you don't especify location will use the location setuped in your app engine
```

- Config your queue (Optional):

```bash
 gcloud tasks queues update [QUEUE_ID_OR_NAME] \
   --max-dispatches-per-second=10 \
   --max-attempts=5 \
   --max-retry-duration=600s
```

5. Add the required envs for this library in your `env` file:

```js
  CLOUD_TASK_PROJECT_ID= // Id of the project where you create the task
  CLOUD_TASK_APP_ENGINE_SERVICE= // If you are using the default app engine remains empty
  CLOUD_TASK_LOCATION_ID= //YOUR Task region e.g us-central-1
  CLOUD_TASK_QUEUE_ID= // Your task name or identificator
  CLOUD_TASK_SECRET_KEY= // Internal secret key, you can use the same you are using in "APP_KEY"
  CLOUD_TASK_IS_ACTIVE= // If you don't want to run background tasks is not need it. Otherwise, you need to set this value to 1
```

6. Add tots-cloud-task-laravel provider into `app.php` file:

```php

  <?php
  use Illuminate\Support\ServiceProvider;

  return [
  //other configs

  "providers" => ServiceProvider::defaultProviders()->merge([
      //other providers
      \Tots\CloudTask\Providers\TaskServiceProvider::class,
    ])->toArray(),
  ]
```

This will allow you to use it directly into your services or controllers directly from the construct.
e.g

```php

  // other imports
  use Tots\CloudTask\Services\TaskService;


  class ExampleService {
    //other protected
    protected TaskService $taskService;

    public function __construct(SystemService $systemService, PromotionRepository $promotionRepository, TaskService $taskService) {
      //other declaraitons

      $this->taskService = $taskService;

    }


    //other functions

    public function exampleFunctionThatExecutionYourTask() {
      //execute task
      $this->taskService->executeTask(ExampleTask::class, taskParams);
    }
  }

```

7. Create `task.php` into `config` folder

```php
  <?php

  return [
      'project_id' => env('CLOUD_TASK_PROJECT_ID', ''),
      'app_engine_service' => env('CLOUD_TASK_APP_ENGINE_SERVICE', ''),
      'location_id' => env('CLOUD_TASK_LOCATION_ID', ''),
      'queue_id' => env('CLOUD_TASK_QUEUE_ID', ''),
      'secret_key' => env('CLOUD_TASK_SECRET_KEY', ''),
      'is_active' => env('CLOUD_TASK_IS_ACTIVE', 0),
  ];

```

This file is used to config the library.

8. Create your tasks into your `Task` folder inside `app` folder being sure you're implementing `BaseTask` type

```php
  <?php

    namespace App\Tasks;


    //other imports
    use Tots\CloudTask\Tasks\BaseTask;

    class ExampleTask implements BaseTask
    {
        public function run($params)
        {

          // do whatever you need to do

        }
    }
```

9. If you want to run a background task is important to create a handler route into the API and add a new environment value.

   - In your api routes file add the following route:

   ```php
     Route::post('/task/handler', ['uses' => \Tots\CloudTask\Http\Controllers\TaskController::class . '@handle']);
   ```

   - In your env file add the following value:

   ```js
   // other cloud task values
   CLOUD_TASK_IS_ACTIVE = 1
   ```

   > When run a background task? You will need to run a background task when you don't want to run the task in a normal workflow, blocking it until the task is finished
   > e.g send emails, process huge amount of data, execute a task in a future date.

## 📞 Contact

For support or questions, please contact to:

Developer: <a href="mailto:matias@tots.agency" target="_blank">Matias Camilleti</a>
