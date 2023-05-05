<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        $parts = explode('/', $name);

        $nameSpace = $parts[0]; 

        $className = $parts[1];
        
        $path = app_path('Services/' . $name . '.php');

        if (File::exists($path)) {
            $this->error('Service already exists!');
            return;
        }

        File::put($path, $this->serviceTemplate($className, $nameSpace));

        $this->info('Service created successfully.');
    }

        protected function serviceTemplate($className, $nameSpace)
        {
            return "<?php

namespace App\\Services\\{$nameSpace};

class {$className}
{
    function __construct()
    {
    }

    //
}
";
        }
}
