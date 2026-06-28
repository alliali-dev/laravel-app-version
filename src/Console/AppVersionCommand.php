<?php

namespace AllialiDev\AppVersion\Console;

use Illuminate\Console\Attributes\{Description, Signature};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('app:version {type=patch : Le type d\'incrémentation (major, minor, patch)}')]
#[Description('Commande pour générer la version actuelle de l\'application.')]
class AppVersionCommand extends Command
{
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
        // Le chemin du fichier
        $path = base_path('version.json');

        // Récupérer la version actuelle ou initialiser
        if (File::exists($path)) {
            $data = json_decode(File::get($path), true);
            $currentVersion = $data['version'] ?? '1.0.0';
        } else {
            $currentVersion = '1.0.0';
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

        // Enregistrer dans version.json
        File::put($path, json_encode(['version' => $newVersion], JSON_PRETTY_PRINT));
        $this->info("Version mise à jour avec succès : v{$newVersion}");

        return Command::SUCCESS;
    }
}
