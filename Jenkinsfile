pipeline {
    agent any

    environment {
        COMPOSE_HOMOLOG = 'docker/homolog/docker-compose.yml'
        COMPOSE_PROD    = 'docker/prod/docker-compose.yml'
        SONAR_URL       = 'http://sonarqube:9000'
    }

    stages {

        stage('A - Checkout') {
            steps {
                echo '==> Obtendo código fonte do repositório...'
                checkout scm
            }
        }

        stage('B - Instalação de Dependências') {
            steps {
                echo '==> Instalando dependências PHP...'
                sh 'docker run --rm -v $(pwd)/app:/app -w /app composer:latest composer install --no-interaction --prefer-dist'
            }
        }

        stage('C - Versionamento') {
            steps {
                echo '==> Código versionado via Git/GitHub (etapa informativa)'
                sh 'git log --oneline -5'
            }
        }

        stage('D - Testes Automatizados') {
            steps {
                echo '==> Executando 20 testes automatizados com PHPUnit...'
                sh '''
                    docker run --rm \
                        -v $(pwd)/app:/app \
                        -w /app \
                        php:8.2-cli \
                        vendor/bin/phpunit --configuration phpunit.xml --testdox
                '''
            }
            post {
                always {
                    echo '==> Publicando relatório de testes...'
                    junit 'app/coverage/junit.xml'
                }
            }
        }

        stage('E - Análise de Qualidade (SonarQube)') {
            steps {
                echo '==> Analisando qualidade de código com SonarQube...'
                sh '''
                    docker run --rm \
                        --network gcs_ci \
                        -v $(pwd)/app:/app \
                        -w /app \
                        sonarsource/sonar-scanner-cli \
                        sonar-scanner \
                            -Dsonar.host.url=${SONAR_URL} \
                            -Dsonar.projectKey=gcs-projeto \
                            -Dsonar.sources=app,routes,database \
                            -Dsonar.tests=tests \
                            -Dsonar.php.coverage.reportPaths=coverage/clover.xml \
                            -Dsonar.php.tests.reportPath=coverage/junit.xml
                '''
            }
        }

        stage('F - Deploy Homologação') {
            steps {
                echo '==> Atualizando ambiente de Homologação...'
                sh '''
                    cp app/.env.homolog app/.env
                    docker compose -f ${COMPOSE_HOMOLOG} up -d --build
                    sleep 10
                    docker compose -f ${COMPOSE_HOMOLOG} exec -T app_homolog php artisan migrate --force
                '''
            }
        }

        stage('G - Deploy Produção') {
            input {
                message 'Deseja atualizar o ambiente de Produção?'
                ok 'Sim, fazer deploy!'
            }
            steps {
                echo '==> Atualizando ambiente de Produção...'
                sh '''
                    cp app/.env.prod app/.env
                    docker compose -f ${COMPOSE_PROD} up -d --build
                    sleep 10
                    docker compose -f ${COMPOSE_PROD} exec -T app_prod php artisan migrate --force
                '''
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline concluído com sucesso!'
        }
        failure {
            echo '❌ Pipeline falhou. Verifique os logs acima.'
        }
    }
}
