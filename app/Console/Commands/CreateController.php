<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controllers CLI';

    public function handle()
    {
        $fullString = $this->argument('name');
        $split = explode('-', $fullString);

        // Kiểm tra cú pháp đầu vào
        if (count($split) !== 2) {
            $this->error('Invalid name format. Expected format: Name-Folder');
            return 1;
        }

        $name = $split[0];
        $folderName = $split[1];

        if ($folderName === 'Backend' || $folderName === 'Fontend') {
            $controllerFolder = base_path('app/Http/Controllers/' . $folderName);

            // Tạo thư mục nếu chưa tồn tại
            File::ensureDirectoryExists($controllerFolder);

            $controllerFile = $controllerFolder . '/' . $name . 'Controller.php';

            if (!File::exists($controllerFile)) {
                // Đọc template và thay thế
                $templatePath = app_path('Console/Commands/Templates/Controller.txt');
                if (!File::exists($templatePath)) {
                    $this->error('Template file does not exist!');
                    return 1;
                }

                $controllerFileContent = file_get_contents($templatePath);
                $controllerFileContent = str_replace('{folder}', $folderName, $controllerFileContent);
                $controllerFileContent = str_replace('{name}', $name, $controllerFileContent);

                // Ghi file controller
                File::put($controllerFile, $controllerFileContent);
                $this->info('Controller created successfully: ' . $controllerFile);
            } else {
                $this->error('Controller already exists!');
                return 1;
            }
        } else {
            $this->error('Folder must be "Backend" or "Fontend".');
            return 1;
        }
    }
}
