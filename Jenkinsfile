pipeline {
    agent any

    environment {
        WORKSPACE_APP = "${WORKSPACE}/app"
        COMPOSE_HOMOLOG = "${WORKSPACE}/docker/homolog/docker-compose.yml"
        COMPOSE_PROD    = "${WORKSPACE}/docker/prod/docker-compose.yml"
        SONAR_URL       = 'http://gcs_sonarqube:9000'
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
                sh 'docker run --rm -v ${WORKSPACE_APP}:/app -w /app composer:latest composer install --no-interaction --prefer-dist'
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
                        -v ${WORKSPACE_APP}:/app \
                        -w /app \
                        php:8.2-cli \
                        vendor/bin/phpunit --configuration phpunit.xml --testdox
                '''
            }
        }

        stage('E - Análise de Qualidade (SonarQube)') {
            steps {
                echo '==> Analisando qualidade de código com SonarQube...'
                sh '''
                    docker run --rm \
                        --network jenkins_gcs_ci \
                        -v ${WORKSPACE_APP}:/app \
                        -w /app \
                        sonarsource/sonar-scanner-cli \
                        sonar-scanner \
                            -Dsonar.projectKey=gcs-projeto \
                            -Dsonar.sources=app,routes,database \
                            -Dsonar.tests=tests \
                            -Dsonar.host.url=${SONAR_URL} \
                            -Dsonar.login=admin \
                            -Dsonar.password=admin
                '''
            }
        }

        stage('F - Deploy Homologação') {
            steps {
                echo '==> Atualizando ambiente de Homologação...'
                sh '''
                    cp ${WORKSPACE_APP}/.env.homolog ${WORKSPACE_APP}/.env
                    docker compose -f ${COMPOSE_HOMOLOG} up -d --build
                    sleep 15
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
                    cp ${WORKSPACE_APP}/.env.prod ${WORKSPACE_APP}/.env
                    docker compose -f ${COMPOSE_PROD} up -d --build
                    sleep 15
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
