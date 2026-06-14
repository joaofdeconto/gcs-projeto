#!/bin/bash
# Inicia Jenkins + SonarQube
echo "==> Iniciando Jenkins e SonarQube..."
docker compose -f jenkins/docker-compose.yml up -d
echo ""
echo "✅ Jenkins:   http://localhost:8090"
echo "✅ SonarQube: http://localhost:9000"
echo ""
echo "Aguardando Jenkins iniciar (~60s)..."
sleep 60
echo "==> Senha inicial do Jenkins:"
docker exec gcs_jenkins cat /var/jenkins_home/secrets/initialAdminPassword 2>/dev/null || echo "Jenkins ainda inicializando, aguarde mais um momento."
