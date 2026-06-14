# GCS Projeto 2026/A
**Gerência de Configuração de Software — Tarefa Final**

## Stack
| Componente | Tecnologia |
|---|---|
| Linguagem | PHP 8.2 + Laravel 11 |
| Banco de Dados | MySQL 8.0 |
| Servidor Web | Nginx |
| Containers | Docker + Docker Compose |
| CI/CD | Jenkins |
| Qualidade | SonarQube |
| Testes | PHPUnit (20 testes) |

## Portas
| Serviço | Porta |
|---|---|
| Jenkins | 8090 |
| SonarQube | 9000 |
| App Homolog | 8081 |
| App Prod | 8082 |
| MySQL Homolog | 3307 |
| MySQL Prod | 3308 |

## Como usar

### 1. Iniciar Jenkins + SonarQube
```bash
bash scripts/start-ci.sh
```

### 2. Deploy Homologação
```bash
bash scripts/deploy-homolog.sh
```

### 3. Deploy Produção
```bash
bash scripts/deploy-prod.sh
```

### 4. Executar testes
```bash
bash scripts/run-tests.sh
```

### 5. Parar tudo
```bash
bash scripts/stop-all.sh
```

## Pipeline (Jenkinsfile)
A → Checkout → B → Dependências → C → Versionamento → D → Testes → E → SonarQube → F → Deploy Homolog → G → Deploy Prod (aprovação manual)
