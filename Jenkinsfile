pipeline {
    agent any

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
                sh '''
                    docker run --rm \
                        -v ${WORKSPACE}/app:/app \
                        -w /app \
                        composer:latest composer install --no-interaction --prefer-dist
                '''
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
                        -v ${WORKSPACE}/app:/app \
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
                        -v ${WORKSPACE}/app:/app \
                        -w /app \
                        sonarsource/sonar-scanner-cli \
                        sonar-scanner \
                            -Dsonar.projectKey=gcs-projeto \
                            -Dsonar.sources=app,routes,database \
                            -Dsonar.tests=tests \
                            -Dsonar.host.url=http://gcs_sonarqube:9000 \
                            -Dsonar.login=admin \
                            -Dsonar.password=admin
                '''
            }
        }

        stage('F - Deploy Homologação') {
            steps {
                echo '==> Atualizando ambiente de Homologação...'
                sh '''
                    cp ${WORKSPACE}/app/.env.homolog ${WORKSPACE}/app/.env
                    docker compose -f ${WORKSPACE}/docker/homolog/docker-compose.yml up -d --build
                    sleep 15
                    docker compose -f ${WORKSPACE}/docker/homolog/docker-compose.yml exec -T app_homolog php artisan migrate --force
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
                    cp ${WORKSPACE}/app/.env.prod ${WORKSPACE}/app/.env
                    docker compose -f ${WORKSPACE}/docker/prod/docker-compose.yml up -d --build
                    sleep 15
                    docker compose -f ${WORKSPACE}/docker/prod/docker-compose.yml exec -T app_prod php artisan migrate --force
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
