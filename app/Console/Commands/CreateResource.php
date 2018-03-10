<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api
                            {name : The name of the resource (lowercase/singular)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new app resource (model, migration, etc). For composite names, add underscores';

    protected $modelPath = 'Models';
    protected $controllerPath = 'App\Http\Controllers';
    protected $managerPath = 'Managers';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->warn('Creating resource with name: '.$this->getPascalCaseName());

        // Create migration
        if (!$this->createMigration()) {
            $this->abort();

            return;
        }

        // Create model
        if (!$this->createModel()) {
            $this->abort();

            return;
        }

        // Create manager
        if (!$this->createManager()) {
            $this->abort();

            return;
        }

        // Create manager facade
        if (!$this->createManagerFacade()) {
            $this->abort();

            return;
        }

        // Create controller
        if (!$this->createController()) {
            $this->abort();

            return;
        }

        $this->success();
    }

    /**
     * Creates the migration file for the resource
     *
     * @return bool
     */
    protected function createMigration()
    {
        $name = $this->getPascalCaseName();
        $file = __DIR__.'/resource/stubs/api/migration.stub';
        $fileName = date('Y_m_d_His').'_create_'.strtolower($this->argument('name')).'s_table.php';
        $path = base_path('/database/migrations/').$fileName;

        if ($this->fileExists($path, 'Migration')) {
            return false;
        }

        $className = 'Create'.$name.'sTable';
        $table = strtolower($this->argument('name').'s');

        $fileContents = file_get_contents($file);
        $fileContents = str_replace('{{class}}', $className, $fileContents);
        $fileContents = str_replace('{{table}}', $table, $fileContents);

        if (!$this->fileCreated($path, $fileContents, 'migration')) {
            return false;
        }

        $this->info('Migration: '.$fileName.' created');

        return true;
    }

    /**
     * Creates the model file for the resource
     *
     * @return bool
     */
    protected function createModel()
    {
        $name = $name = $this->getPascalCaseName();
        $file = __DIR__.'/resource/stubs/api/model.stub';
        $path = app_path($this->modelPath).'/'.$name.'.php';

        if ($this->fileExists($path, 'Model')) {
            return false;
        }

        $fileContents = file_get_contents($file);
        $fileContents = str_replace('Dummy', $name, $fileContents);

        if (!$this->fileCreated($path, $fileContents, 'model')) {
            return false;
        }

        $this->info('Model: '.$name.' created ');

        return true;
    }

    /**
     * Creates the manager file for the resource
     *
     * @return bool
     */
    protected function createManager()
    {
        $name = $this->getPascalCaseName();
        $file = __DIR__.'/resource/stubs/api/manager.stub';
        $dirPath = app_path($this->managerPath).'/'.$name.'s';
        $path = $dirPath.'/'.$name.'sManager.php';

        $this->createDirectory($dirPath);

        if ($this->fileExists($path, 'Manager')) {
            return false;
        }

        $fileContents = file_get_contents($file);
        $fileContents = str_replace('{{name}}', $name.'s', $fileContents);
        $fileContents = str_replace('{{lowSinName}}', $this->getCamelCaseName(), $fileContents);
        $fileContents = str_replace('{{model}}', $name, $fileContents);

        if (!$this->fileCreated($path, $fileContents, 'manager')) {
            return false;
        }

        $this->info('Manager: '.$name.'sManager created');

        return true;
    }

    /**
     * Creates the manager facade file for the resource
     *
     * @return bool
     */
    protected function createManagerFacade()
    {
        $name = $this->getPascalCaseName();
        $file = __DIR__.'/resource/stubs/api/facade.stub';
        $dirPath = app_path($this->managerPath).'/'.$name.'s';
        $path = $dirPath.'/'.$name.'sManagerFacade.php';

        if ($this->fileExists($path, 'ManagerFacade')) {
            return false;
        }

        $fileContents = file_get_contents($file);
        $fileContents = str_replace('{{name}}', $name.'s', $fileContents);
        $fileContents = str_replace('{{manager}}', $name.'sManager', $fileContents);

        if (!$this->fileCreated($path, $fileContents, 'manager facade')) {
            return false;
        }

        $this->info('ManagerFacade: '.$name.'sManagerFacade created');

        // Adding application alias so that the facade
        // can be used
        $facade = '\''.$name.'sManager'.'\' => '.$this->managerPath.'\\'.$name.'s\\'.$name.'sManagerFacade::class,';

        $appConfig = base_path('config/app.php');
        $content = file_get_contents($appConfig);
        $delimiter = '// END OF APP ALIASES - DO NOT REMOVE/MODIFY THIS COMMENT';

        $endOfPos = strpos($content, $delimiter);
        $pre = substr($content, 0, $endOfPos);
        $post = substr($content, $endOfPos, strlen($content));

        file_put_contents($appConfig, $pre.$facade."\n\t\t".$post);

        $this->info('Added facade alias in `config/app.php`');

        return true;
    }

    /**
     * Creates the api controller file for the resource
     *
     * @return bool
     */
    protected function createController()
    {
        $name = $this->getPascalCaseName();
        $file = __DIR__.'/resource/stubs/api/controller.stub';
        $dirPath = app_path('Http/Controllers');
        $path = $dirPath.'/'.$name.'sController.php';

        if ($this->fileExists($path, 'Controller')) {
            return false;
        }

        $content = file_get_contents($file);
        $content = str_replace('{{namespace}}', $this->controllerPath, $content);
        $content = str_replace('{{manager}}', $name.'sManager', $content);
        $content = str_replace('{{name}}', $name.'s', $content);
        $content = str_replace('{{lowSinName}}', strtolower($name), $content);
        $content = str_replace('{{lowUnderscoreName}}', strtolower($this->argument('name')), $content);

        if (!$this->fileCreated($path, $content, 'controller')) {
            return false;
        }

        $this->info('Controller: '.$name.'sController created');

        // Adding routes the controller will use
        $resource = 'Route::resource(\''.$this->getRouteName().'s\', \''.$name.'sController\', [';
        $resource .= "\n\t\t\t".'\'except\' => [\'create\', \'edit\']';
        $resource .= "\n\t\t".']);';

        $routePath = base_path('routes/api.php');
        $content = file_get_contents($routePath);
        $delimiter = '// END OF RESOURCE API - DO NOT REMOVE/MODIFY THIS COMMENT';

        $endOfPos = strpos($content, $delimiter);
        $pre = substr($content, 0, $endOfPos);
        $post = substr($content, $endOfPos, strlen($content));

        file_put_contents($routePath, $pre.$resource."\n\n\t\t".$post);

        $this->info('Added route resource in `routes/api.php`');

        return true;
    }

    /**
     * If the file exists, returns true. False otherwise
     *
     * @param $path
     * @param $type
     * @return bool
     */
    protected function fileExists($path, $type)
    {
        if (file_exists($path)) {
            $this->error($type.' already exists');

            return true;
        }

        return false;
    }

    /**
     * If the file was successfully created, it returns true,
     * false otherwise
     *
     * @param $path
     * @param $content
     * @param $type
     * @return bool
     */
    protected function fileCreated($path, $content, $type)
    {
        if (!file_put_contents($path, $content)) {
            $this->error('Unable to create '.$type);

            return false;
        }

        return true;
    }

    /**
     * Creates directory if it doesn't exist
     *
     * @param $path
     */
    protected function createDirectory($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    /**
     * Displays an abort message
     */
    protected function abort()
    {
        $this->warn('aborting...');
    }

    /**
     * Gets the pascal case name
     */
    protected function getPascalCaseName()
    {
        $words = explode('_', $this->argument('name'));
        $name = '';

        foreach($words as $word) {
            $name .= strtoupper(substr($word, 0, 1));
            $name .= strtolower(substr($word, 1, strlen($word) - 1));
        }

        return $name;
    }

    /**
     * Gets the camel case name
     */
    protected function getCamelCaseName()
    {
        $words = explode('_', $this->argument('name'));
        $name = '';
        $counter = 0;

        foreach($words as $word) {
            if ($counter === 0) {
                $name = strtolower($word);

                $counter++;
                continue;
            }

            $name .= strtoupper(substr($word, 0, 1));
            $name .= strtolower(substr($word, 1, strlen($word) - 1));
        }

        return $name;
    }

    /**
     * Gets the route name
     */
    protected function getRouteName()
    {
        return strtolower(str_replace('_', '-', $this->argument('name')));
    }

    /**
     * Displays a success message
     */
    protected function success()
    {
        $name = $this->getPascalCaseName();
        $managerPath = 'app/'.$this->managerPath.'/'.$name.'s/'.$name.'sManager';
        $controllerName = $name.'s';

        $this->warn('Resource files created');
        $this->line('');
        $this->warn('__________________________________________________');
        $this->info('This is not magic. Make sure you do the following:');
        $this->line('');
        $this->warn('1. Open the migration file and add your fields (`app/database/migrations`)');
        $this->line('');
        $this->warn('2. Open the model and fill in the `fillable` array (`app/Models/'.$name.'`)');
        $this->line('');
        $this->warn('3. Open the manager and add the fields required for `create` and `update` (`'.$managerPath.'`)');
        $this->line('');
        $this->warn('4. Open the controller and complete the ApiValidator with your rules. Make sure you add ALL the parameters in the comments. This step is required to populate the api documentation. (`app/Http/Controllers/'.$controllerName.'`)');
        $this->line('');
        $this->warn('5. run `php artisan migrate` when done');
        $this->line('');
        $this->warn('6. Run `php artisan apidocs:generate` and enter the api route (usually `api/v1`)');
        $this->line('');

        $this->info('If you want an admin panel for this resource, run `php artisan lucy:resource:admin '.strtolower($name).'`');
        $this->info('Happy coding.');
    }
}
