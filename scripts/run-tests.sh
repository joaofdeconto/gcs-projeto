#!/bin/bash
# Executa os testes localmente
echo "==> Executando 20 testes com PHPUnit..."
docker run --rm \
    -v $(pwd)/app:/app \
    -w /app \
    php:8.2-cli \
    vendor/bin/phpunit --configuration phpunit.xml --testdox
echo ""
echo "==> Relatório gerado em: app/coverage/"
