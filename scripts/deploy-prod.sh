#!/bin/bash
# Deploy manual do ambiente de Produção
echo "==> Fazendo deploy em Produção..."
cp app/.env.prod app/.env
docker compose -f docker/prod/docker-compose.yml up -d --build
echo "==> Aguardando banco de dados..."
sleep 15
docker compose -f docker/prod/docker-compose.yml exec app_prod php artisan migrate --force
docker compose -f docker/prod/docker-compose.yml exec app_prod php artisan db:seed --force
echo ""
echo "✅ Produção disponível em: http://localhost:8082"
