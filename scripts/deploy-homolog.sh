#!/bin/bash
# Deploy manual do ambiente de Homologação
echo "==> Fazendo deploy em Homologação..."
cp app/.env.homolog app/.env
docker compose -f docker/homolog/docker-compose.yml up -d --build
echo "==> Aguardando banco de dados..."
sleep 15
docker compose -f docker/homolog/docker-compose.yml exec app_homolog php artisan migrate --force
docker compose -f docker/homolog/docker-compose.yml exec app_homolog php artisan db:seed --force
echo ""
echo "✅ Homologação disponível em: http://localhost:8081"
