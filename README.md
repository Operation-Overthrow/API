# Operation Overthrow API


## Prérequis

- [PHP](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [OpenSSL](https://www.openssl.org/source/)
- [Docker](https://docs.docker.com/get-docker/)
- [Ddev (optionnel)](https://ddev.readthedocs.io/en/stable/#installation)


## Installation

```bash
# 1. Cloner le projet
git clone https://github.com/Operation-Overthrow/API

# 2. Installer les dépendances
cd API
composer install
```

## Lancer le projet

Il y a deux façons de lancer le projet en local, avec docker compose ou avec ddev (recommandé sur Linux).

### Avec docker compose

```bash
docker compose up -d
docker exec -it operation_overthrow_api /bin/sh
```

### Avec ddev

```bash
ddev start
ddev ssh
```

## Configuration

```bash
# 4. Générer les clés pour les JWT 
php bin/console lexik:jwt:generate-keypair
# Uniquement via docker compose
sudo chown -R nginx:nginx config/jwt

# 5. Modifier le mot de passe JWT dans le .env.local
cp .env .env.local
## Il faut modifier la ligne JWT_PASSPHRASE= en indiquant le mot de passe

# 6. Lancer les migrations
php bin/console d:m:m
```

## Urls utiles

Comme il y a deux setup différents, il y a deux types d'urls différentes pour accéder aux différents services.

### Avec docker compose
- [Site](http://localhost:8000)
- [PhpMyAdmin](http://localhost:8037)
- [Mailhog](http://localhost:8025)
- [Swagger](http://localhost:8000/api/doc)

### Avec ddev
- [Site](https://operation-overthrow-api.ddev.site)
- [PhpMyAdmin](https://operation-overthrow-api.ddev.site:8037)
- [Mailhog](https://operation-overthrow-api.ddev.site:8026)
- [Swagger](https://operation-overthrow-api.ddev.site/api/doc)

### Démo
- [Site](https://operation-overthrow-api.melaine-gerard.fr)
- [Swagger](https://operation-overthrow-api.melaine-gerard.fr/api/doc)
