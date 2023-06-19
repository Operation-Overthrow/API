# Operation Overthrow API


## Prérequis

- [PHP](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [OpenSSL](https://www.openssl.org/source/)
- [Docker](https://docs.docker.com/get-docker/)


## Installation

```bash
# 1. Cloner le projet
git clone https://github.com/Operation-Overthrow/API

# 2. Installer les dépendances
cd API
composer install

# 3. Lancer les containers docker
docker compose up -d
docker exec -it operation_overthrow_api /bin/sh

# 4. Générer les clés pour les JWT 
php bin/console lexik:jwt:generate-keypair
sudo chown -R nginx:nginx config/jwt

# 5. Modifier le mot de passe JWT dans le .env.local
cp .env .env.local
## Il faut modifier la ligne JWT_PASSPHRASE= en indiquant le mot de passe

# 6. Lancer les migrations
php bin/console d:m:m
```

## Urls utiles

- [Site](http://localhost:8000)
- [PhpMyAdmin](http://localhost:8037)
- [Mailhog](http://localhost:8025)
- [Swagger](http://localhost:8000/api/doc)