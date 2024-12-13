<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteFullApi extends Command
{
    protected $signature = 'delete:fullapi {name}';
    protected $description = 'Supprimer un modèle, migration, contrôleur, resource, request, factory, seeder et DTO associés à une ressource spécifique';

    public function handle()
    {
        $name = $this->argument('name');
        $pluralName = Str::plural(Str::snake($name));
        $className = Str::studly($name);

        $this->info("Suppression des fichiers pour : {$name}");

        // Supprimer le modèle
        $this->deleteFile(app_path("Models/{$className}.php"), "Modèle");

        // Supprimer les migrations
        $this->deleteFilesByPattern(database_path('migrations'), "*_create_{$pluralName}_table.php", "Migration");

        // Supprimer le service
        $this->deleteFile(app_path("Services/{$className}Service.php"), "Service");

        // Supprimer la policy
        $this->deleteFile(app_path("Policies/{$className}Policy.php"), "Policy");
        $this->removeFromAuthServiceProvider($className);

        // Supprimer le contrôleur
        $this->deleteFile(app_path("Http/Controllers/{$className}Controller.php"), "Contrôleur");

        // Supprimer la resource
        $this->deleteFile(app_path("Http/Resources/{$className}Resource.php"), "Resource");

        // Supprimer la requête
        $this->deleteFile(app_path("Http/Requests/{$className}Request.php"), "Requête");

        // Supprimer le seeder
        $this->deleteFile(database_path("seeders/{$className}Seeder.php"), "Seeder");

        // Supprimer le factory
        $this->deleteFile(database_path("factories/{$className}Factory.php"), "Factory");

        // Supprimer le DTO
        $this->deleteFile(app_path("DTO/{$className}DTO.php"), "DTO");

        $this->info("Tous les fichiers associés à {$name} ont été supprimés.");
    }

    private function deleteFile($filePath, $type)
    {
        if (File::exists($filePath)) {
            File::delete($filePath);
            $this->info("{$type} supprimé : {$filePath}");
        } else {
            $this->warn("{$type} introuvable : {$filePath}");
        }
    }

    private function deleteFilesByPattern($directory, $pattern, $type)
    {
        $files = File::glob("{$directory}/{$pattern}");
        if ($files) {
            foreach ($files as $file) {
                File::delete($file);
                $this->info("{$type} supprimé : {$file}");
            }
        } else {
            $this->warn("Aucun fichier {$type} correspondant au motif : {$pattern}");
        }
    }

    private function removeFromAuthServiceProvider($className)
    {
        $providerPath = app_path('Providers/AuthServiceProvider.php');
        
        if (!file_exists($providerPath)) {
            $this->warn("AuthServiceProvider n'existe pas.");
            return;
        }

        $content = file_get_contents($providerPath);

        // Supprimer les imports
        $content = preg_replace("/use App\\\\Models\\\\{$className};\n/", '', $content);
        $content = preg_replace("/use App\\\\Policies\\\\{$className}Policy;\n/", '', $content);

        // Supprimer le mapping de la policy
        $content = preg_replace("/\s*{$className}::class => {$className}Policy::class,/", '', $content);

        file_put_contents($providerPath, $content);
        $this->info("Policy supprimée de AuthServiceProvider");
    }
}
