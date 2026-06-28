# Laravel App Version 

[![Latest Version on Packagist](https://shields.io)](https://packagist.org)
[![Total Downloads](https://shields.io)](https://packagist.org)

Ce package permet d'incrémenter automatiquement le numéro de version de votre application Laravel (SemVer) dans un fichier `version.json` à la racine du projet et de créer le tag Git associé, le tout via une simple commande Artisan.

## Installation

Vous pouvez installer ce package via Composer :

```bash
composer require alliali-dev/laravel-app-version
```

Le package utilise la découverte automatique (Package Discovery) de Laravel. Le Service Provider s'enregistrera tout seul.

## Utilisation

Exécutez simplement la commande Artisan en spécifiant le type d'incrément souhaité (`patch`, `minor`, `major`) :

### Mettre à jour un correctif (Patch : 1.0.0 ➡️ 1.0.1)
```bash
php artisan app:version patch
```

### Mettre à jour une fonctionnalité (Minor : 1.0.1 ➡️ 1.1.0)
```bash
php artisan app:version minor
```

### Mettre à jour une version majeure (Major : 1.1.0 ➡️ 2.0.0)
```bash
php artisan app:version major
```

La commande mettra à jour le fichier `version.json` à la racine de votre application et vous proposera de créer automatiquement le Tag Git local correspondant.

## Afficher la version dans Laravel

Dès l'installation du package, la version actuelle de l'application est injectée automatiquement. Vous pouvez la récupérer n'importe où dans votre code (contrôleurs, fichiers Blade, fichiers de configuration) avec la clé suivante :

```php
    \$version = config('version.current'); // Exemple: "1.0.0"
```


Puis l'appeler dans vos fichiers Blade ou vos contrôleurs :
```html
<span>Version : {{ config('version.current') }}</span>
```

### Personnalisation (Optionnel)
Si vous souhaitez modifier le comportement par défaut ou publier le fichier de configuration du package dans votre application, exécutez :

```bash
php artisan vendor:publish --tag=app-version-config
```

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
