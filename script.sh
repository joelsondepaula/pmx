#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="/home/repositorios/pmx"
cd "$PROJECT_DIR"

echo "1) Limpando caches..."
export COMPOSER_ALLOW_SUPERUSER=1
rm -rf bootstrap/cache/*.php || true
rm -rf storage/framework/cache/*.php || true

echo "2) Garantindo .env"
cp -n .env.example .env

# Ajustes seguros no .env
if grep -q '^CACHE_STORE=' .env; then
  sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env
else
  echo 'CACHE_STORE=file' >> .env
fi

if grep -q '^SESSION_DRIVER=' .env; then
  sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
else
  echo 'SESSION_DRIVER=file' >> .env
fi

if ! grep -q '^FILESYSTEM_DISK=' .env; then
  echo 'FILESYSTEM_DISK=local' >> .env
fi

# Gerar APP_KEY se necessário
if ! grep -q '^APP_KEY=' .env; then
  php -r "file_put_contents('.env', PHP_EOL . 'APP_KEY=base64:' . base64_encode(random_bytes(32)) . PHP_EOL, FILE_APPEND);"
else
  if grep -q '^APP_KEY=$' .env; then
    php -r "\$e=file_get_contents('.env'); \$e=preg_replace('/^APP_KEY=\\s*$/m','APP_KEY=base64:'.base64_encode(random_bytes(32)),\$e); file_put_contents('.env',\$e);"
  fi
fi

echo "3) Instalando dependências composer (pode demorar)..."
COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --prefer-dist --optimize-autoloader

echo "4) Limpando caches do framework..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true

echo "5) Tentando gerar APP_KEY com artisan..."
php artisan key:generate --force || true

echo "6) Rodando testes PHPUnit..."
./vendor/bin/phpunit --colors --verbose || true

echo "Script concluído."
