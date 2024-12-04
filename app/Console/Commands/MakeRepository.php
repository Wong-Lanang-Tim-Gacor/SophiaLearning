<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Mendapatkan nama repository dari argumen
        $name = $this->argument('name');
        
        // Menentukan path tempat repository akan disimpan
        $path = app_path("Contracts/Repositories/{$name}Repository.php");

        // Mengecek apakah file sudah ada
        if (File::exists($path)) {
            $this->error("Repository {$name} sudah ada!");
            return;
        }

        // Mengambil template dari stub dan mengganti {{name}} dengan nama yang diberikan
        $stub = $this->getStub();
        $content = str_replace('{{name}}', $name, $stub);

        // Menyimpan file repository
        File::put($path, $content);

        $this->info("Repository {$name}Repository berhasil dibuat.");
    }

    /**
     * Get the stub file for the repository class.
     *
     * @return string
     */
    private function getStub()
    {
        // Template untuk class repository
        return <<<EOT
<?php

namespace App\Contracts\Repositories;

use App\Contracts\Repositories\BaseRepository;
use App\Models\{{name}};

class {{name}}Repository extends BaseRepository
{
    public function __construct({{name}} \$model)
    {
        parent::__construct(\$model);
    }
}
EOT;
    }
}
