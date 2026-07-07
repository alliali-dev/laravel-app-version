<?php

namespace AllialiDev\AppVersion\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class AppVersionCommand extends Command
{
    /**
     * Le nom de la commande
     * @var string
     */
    protected $name = 'app:version';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:version {type=patch : Le type d\'incrémentation (major, minor, patch)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande pour générer la version actuelle de l\'application. Incrémente automatiquement la version de l\'application ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');

        if (!in_array($type, ['major', 'minor', 'patch'])) {
            $this->error("Type invalide ! Choisissez entre : major, minor, patch.");
            return Command::FAILURE;
        }

        $path = base_path('version.json');

        // Récupérer la version actuelle ou initialiser
        if (File::exists($path)) {
            $data = json_decode(File::get($path), true);
            $currentVersion = $data['version'] ?? '1.0.0';
        } else {
            $currentVersion = '1.0.0';
            $data = [];
        }

        // Séparer les composants SemVer (Major.Minor.Patch)
        if (!preg_match('/^v?(\d+)\.(\d+)\.(\d+)$/', $currentVersion, $matches)) {
            $this->error("Le format de version actuel est invalide dans version.json (Attendu: X.Y.Z).");
            return Command::FAILURE;
        }

        $major = (int)$matches[1];
        $minor = (int)$matches[2];
        $patch = (int)$matches[3];

        // Calcul de la nouvelle version
        switch ($type) {
            case 'major':
                $major++;
                $minor = 0;
                $patch = 0;
                break;
            case 'minor':
                $minor++;
                $patch = 0;
                break;
            case 'patch':
                $patch++;
                break;
        }


        $newVersion = "{$major}.{$minor}.{$patch}";
        $now = Carbon::now()->toDateTimeString();

        // Prépare les données
        $history = $data['history'] ?? [];
        $history[$newVersion] = $now;

        $versionData = [
            'version' => $newVersion,
            'last_updated' => $now,
            'history' => $history
        ];

        // Sauvegarde
        File::put($path, json_encode($versionData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Messages de succès
        $this->info("✅ Version mise à jour avec succès : v{$newVersion}");
        $this->info("📅 Date : {$now}");

        $this->newLine();
        $this->info('🎉 Opération terminée avec succès !');
        $this->line('📝 Utilisez app_version() pour afficher la version.');

        return Command::SUCCESS;
    }
}
