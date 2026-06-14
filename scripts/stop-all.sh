#!/bin/bash
# Para todos os ambientes
echo "==> Parando todos os containers..."
docker compose -f jenkins/docker-compose.yml down
docker compose -f docker/homolog/docker-compose.yml down
docker compose -f docker/prod/docker-compose.yml down
echo "✅ Todos os containers parados."
