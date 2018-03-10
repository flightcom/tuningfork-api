<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin
                            {name : The name of the resource (singular)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new admin view for an existing resource';

    protected $controllerPath = 'App\Http\Controllers\Admin';

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
        $this->warn('Creating admin section for: '.$this->getPascalCaseName());

        // Create blade views
        if (!$this->createViews()) {
            $this->abort();

            return;
        }

        // Create admin controller
        if (!$this->createController()) {
            $this->abort();

            return;
        }

        $this->success();
    }

    /**
     * Creates the required admin views
     *
     * @return bool
     */
    protected function createViews()
    {
        $name = $this->getCamelCaseName();
        $stubPath = __DIR__.'/resource/stubs/admin/';
        $dirPath = base_path('resources/views/admin/pages/').$name.'s';

        $files = [
            'index',
            'show',
            'create',
            'edit',
            '_datatable',
            '_form',
        ];

        $this->createDirectory($dirPath);

        if (!$this->createViewsHelper($stubPath, $dirPath, $files, $name)) {
            return false;
        }

        return true;
    }

    /**
     * Helper function for creating views
     *
     * @param $stubPath
     * @param $dirPath
     * @param $files
     * @param $name
     * @return bool
     */
    protected function createViewsHelper($stubPath, $dirPath, $files, $name)
    {
        foreach ($files as $file) {
            if ($this->fileExists($dirPath.$file.'.blade.php', 'Views')) {
                return false;
            }

            $content = file_get_contents($stubPath.$file.'.stub');
            $content = str_replace('{{title}}', $this->getTitleName(), $content);
            $content = str_replace('{{sinName}}', $name, $content);
            $content = str_replace('{{lowSinName}}', $name, $content);
            $content = str_replace('{{lowName}}', $name.'s', $content);
            $content = str_replace('{{routeName}}', $this->getRouteName().'s', $content);
            $content = str_replace('{{lowUnderscoreName}}', strtolower($this->argument('name')), $content);

            if (!$this->fileCreated($dirPath.'/'.$file.'.blade.php', $content, 'View')) {
                return false;
            }

            $this->info('View: '.$file.'.blade.php created');
        }

        return true;
    }

    /**
     * Creates the admin controller
     *
     * @return bool
     */
    protected function createController()
    {
        $pascalName = $this->getPascalCaseName();
        $camelName = $this->getCamelCaseName();
        $file = __DIR__.'/resource/stubs/admin/controller.stub';
        $dirPath = app_path('Http/Controllers/Admin');
        $path = $dirPath.'/'.$pascalName.'sController.php';

        if ($this->fileExists($path, 'Controller')) {
            return false;
        }

        $content = file_get_contents($file);
        $content = str_replace('{{namespace}}', $this->controllerPath, $content);
        $content = str_replace('{{manager}}', $pascalName.'sManager', $content);
        $content = str_replace('{{name}}', $pascalName.'s', $content);
        $content = str_replace('{{sinName}}', $camelName, $content);
        $content = str_replace('{{lowName}}', $camelName.'s', $content);
        $content = str_replace('{{lowSinName}}', $camelName, $content);
        $content = str_replace('{{lowUnderscoreName}}', strtolower($this->argument('name')), $content);
        $content = str_replace('{{title}}', $this->getTitleName(), $content);
        $content = str_replace('{{routeName}}', $this->getRouteName().'s', $content);


        if (!$this->fileCreated($path, $content, 'controller')) {
            return false;
        }

        $this->info('Controller: '.$pascalName.'sController created');

        // Adding routes the controller will use
        $this->addRoute();

        // Adding AdminViewsManager function for pagination
        $this->addViewPaginateFunction();

        // Adding admin navigation link
        $this->adminSidebarLink();

        return true;
    }

    /**
     * Adds the route required for the controller
     * @param $name
     */
    protected function addRoute()
    {
        $name = $this->getPascalCaseName();
        $resource = 'Route::resource(\''.$this->getRouteName().'s\', \''.$name.'sController\');';

        $routePath = base_path('routes/web.php');
        $content = file_get_contents($routePath);
        $delimiter = '// END OF RESOURCE ROUTES - DO NOT REMOVE/MODIFY THIS COMMENT';

        $endOfPos = strpos($content, $delimiter);
        $pre = substr($content, 0, $endOfPos);
        $post = substr($content, $endOfPos, strlen($content));

        file_put_contents($routePath, $pre.$resource."\n\n\t".$post);

        $this->info('Added route resource in `routes/web.php`');
    }

    /**
     * The admin queries are special because there are specific
     * params that can be specified for special filters. We don't
     * want to polute the regular managers with these so we created
     * a special manager that deal specifically with them
     *
     * @param $name
     */
    protected function addViewPaginateFunction()
    {
        $lowerName = $this->getCamelCaseName().'s';
        $name = $this->getPascalCaseName();
        $managerPath = app_path('Managers/Views/AdminViewsManager.php');
        $content = file_get_contents($managerPath);

        $importDelimiter = '// END OF MODELS IMPORT - DO NOT REMOVE/MODIFY THIS COMMENT';
        $funcDelimiter = '// END OF ADMIN VIEWS - DO NOT REMOVE/DELETE THIS COMMENT';

        // Function
        $function = '/**'."\n\t";
        $function .= ' * This function returns required information to display on the';
        $function .= ' '.$lowerName."\n\t".' * view'."\n\t".' *'."\n\t";
        $function .= ' * @param int $perPage'."\n\t".' * @param string $search'."\n\t";
        $function .= ' * @return array'."\n\t".' */'."\n\t";
        $function .= 'public function get'.$name.'s($perPage = 15, $search = null)';
        $function .= "\n\t".'{'."\n\t\t";

        $function .= '$'.$lowerName.' = '.$name.'::select(['."\n\t\t\t";
        $function .= '\'id\','."\n\t\t\t";
        $function .= '\'field\','."\n\t\t\t";
        $function .= '\'created_at\','."\n\t\t\t";
        $function .= '\'updated_at\',';
        $function .= "\n\t\t".']); // TODO'."\n\n\t\t";

        $function .= 'if ($search) {'."\n\t\t\t";
        $function .= '$'.$lowerName.'->where(\'field\', \'LIKE\', "%$search%"); // TODO';
        $function .= "\n\t\t".'};'."\n\n\t\t";

        $function .= 'return [ \'data\' => ';
        $function .= '$'.$lowerName.'->paginate($perPage) ];';

        $function .= "\n\t".'}'."\n";

        // Import
        $import = 'use Models\\'.$name.';'."\n";

        // Adding the import
        $endOfImport = strpos($content, $importDelimiter);
        $preImport = substr($content, 0, $endOfImport);
        $postImport = substr($content, $endOfImport, strlen($content));

        $content = $preImport.$import.$postImport;

        // Adding the function
        $endOfFunc = strpos($content, $funcDelimiter);
        $preFunc = substr($content, 0, $endOfFunc);
        $postFunc = substr($content, $endOfFunc, strlen($content));

        // Save the file
        file_put_contents($managerPath, $preFunc.$function."\n\t".$postFunc);

        $this->info('Added resource function in `app/Managers/Views/AdminViewsManager.php`');
    }

    /**
     * Since our management tool has a sidebar navigation, we need to
     * add the resource to the sidebar.
     *
     * @param $name
     */
    protected function adminSidebarLink()
    {
        $lowSinName = strtolower($this->argument('name'));
        $lowName = strtolower($this->argument('name').'s');
        $title = $this->getTitleName().'s';

        $path = base_path('resources/views/admin/includes/sidebar/management.blade.php');
        $delimiter = '{{--END OF MANAGEMENT LINKS - DO NOT REMOVE/MODIFY THIS COMMENT--}}';
        $content = file_get_contents($path);

        // What to add
        $link = '@if(authorized(\''.$lowSinName.'_index\'))';
        $link .= "\n\t".'<li class="{{ activeRoute(\'admin.'.$lowName.'.index\') }}">';
        $link .= "\n\t\t".'<a href="{{ route(\'admin.'.$lowName.'.index\') }}">';
        $link .= "\n\t\t\t".'<i class="ion ion-bug" aria-hidden="true"></i>';
        $link .= "\n\t\t\t".'<span> '.$title.'</span>';
        $link .= "\n\t\t".'</a>';
        $link .= "\n\t".'</li>';
        $link .= "\n".'@endif';


        // Add the link
        $endOfPos = strpos($content, $delimiter);
        $pre = substr($content, 0, $endOfPos);
        $post = substr($content, $endOfPos, strlen($content));

        file_put_contents($path, $pre.$link."\n\n".$post);

        $this->info('Added sidebar link in the admin panel');
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

    protected function getTitleName()
    {
        $words = explode('_', $this->argument('name'));
        $name = '';
        $counter = 1;

        foreach($words as $word) {
            $name .= strtoupper(substr($word, 0, 1));
            $name .= strtolower(substr($word, 1, strlen($word) - 1));

            if ($counter < count($words)) {
                $name .= ' ';
            }

            $counter++;
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
        $lowName = $this->getCamelCaseName();
        $name = $this->getPascalCaseName();
        $viewsPath = 'app/resources/views/admin/pages/'.$lowName.'s/';
        $controllerName = $name.'sController';

        $this->warn('Resource files created');
        $this->line('');
        $this->warn('__________________________________________________');
        $this->info('This is not magic. Make sure you do the following:');
        $this->line('');
        $this->warn('1. Open `'.$viewsPath.'_form.blade.php` and make sure you add all the form fields for your resource.');
        $this->line('');
        $this->warn('2. Open `'.$viewsPath.'_datatable.blade.php` and make sure you add all the fields you want displayed in the datatable');
        $this->line('');
        $this->warn('3. Open `'.$viewsPath.'show.blade.php` and add all the fields to be displayed');
        $this->line('');
        $this->warn('4. Open the controller and complete the Validator with your rules. Make sure you add ALL the parameters in the comments. This step is required to populate the api documentation. (`app/Http/Controllers/Admin/'.$controllerName.'`)');
        $this->line('');
        $this->warn('5. Open the admin views manager and complete the select and query selector in the `get'.$name.'s` function (`app/Managers/Views/AdminViewsManager.php`');
        $this->line('');
        $this->warn('6. Login to the admin panel with a user that has permissions access. Make sure you sync the permissions to be able to view the resource');

        $this->line('');
        $this->info('Happy coding.');
    }
}
