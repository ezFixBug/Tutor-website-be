<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateRepository extends Command
{
    protected $signature = 'generate:repository {model} {--service}';

    protected $description = 'Generate repository, repository interface, and service for a model';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $modelName = $this->argument('model');
        $repositoryName = "{$modelName}Repository";
        $repositoryInterfaceName = "{$modelName}RepositoryInterface";
        $serviceName = "{$modelName}Service";
        $modelNamespace = 'App\\Models\\' . $modelName;
        $createService = $this->option('service');

        // Create the repository
        $repositoryContent = "<?php\n\nnamespace App\\Repositories;\n\nuse {$modelNamespace};\n\nclass {$repositoryName} implements {$repositoryInterfaceName}\n{\n";
        $repositoryContent .= "    // Implement repository interface methods here\n";
        $repositoryContent .= "}\n";
        file_put_contents(app_path("Repositories/{$repositoryName}.php"), $repositoryContent);

        // Create the repository interface
        $repositoryInterfaceContent = "<?php\n\nnamespace App\\Repositories\\Interfaces;\n\nuse {$modelNamespace};\n\ninterface {$repositoryInterfaceName}\n{\n    // Your repository interface methods here\n}\n";
        file_put_contents(app_path("Repositories/Interfaces/{$repositoryInterfaceName}.php"), $repositoryInterfaceContent);

        if ($createService) {
            // Create the service
            $serviceContent = "<?php\n\nnamespace App\\Services;\n\nuse {$modelNamespace};\nuse App\\Repositories\\{$repositoryName};\nuse App\\Repositories\\{$repositoryInterfaceName};\n\nclass {$serviceName}\n{\n    protected \${$repositoryInterfaceName};\n\n    public function __construct({$repositoryInterfaceName} \${$repositoryName})\n    {\n        \$this->{$repositoryInterfaceName} = \${$repositoryName};\n    }\n    // Your service methods here\n}\n";
            file_put_contents(app_path("Services/{$serviceName}.php"), $serviceContent);
        }

        $this->info("Repository and repository interface for {$modelName} have been generated.");
        if ($createService) {
            $this->info("Service for {$modelName} has been generated.");
        }
    }
}
