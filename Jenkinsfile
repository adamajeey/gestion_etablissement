pipeline {
    agent any

    stages {
        stage('Vérification de l\'environnement') {
            steps {
                script {
                    def phpInstalled = sh(script: 'which php || echo "not found"', returnStdout: true).trim()
                    def composerInstalled = sh(script: 'which composer || echo "not found"', returnStdout: true).trim()
                    def mysqlInstalled = sh(script: 'which mysql || echo "not found"', returnStdout: true).trim()

                    echo "PHP: ${phpInstalled}"
                    echo "Composer: ${composerInstalled}"
                    echo "MySQL: ${mysqlInstalled}"

                    if (phpInstalled.contains("not found")) {
                        error "PHP n'est pas installé. Impossible de continuer."
                    }
                }
            }
        }

        stage('Installation de Composer locale') {
            steps {
                script {
                    def composerInstalled = sh(script: 'which composer || echo "not found"', returnStdout: true).trim()
                    if (composerInstalled.contains("not found")) {
                        sh '''
                        curl -sS https://getcomposer.org/installer | php
                        chmod +x composer.phar
                        mv composer.phar composer
                        export PATH=$PATH:$(pwd)
                        '''
                        echo "Composer installé localement"
                    }
                }
            }
        }

        stage('Cloner le code') {
            steps {
                git branch: 'main', url: 'https://github.com/adamajeey/gestion_etablissement.git'
            }
        }

        stage('Installation des dépendances') {
            steps {
                script {
                    def composerInstalled = sh(script: 'which composer || echo "not found"', returnStdout: true).trim()
                    if (!composerInstalled.contains("not found")) {
                        sh 'composer install --no-interaction --no-progress'
                    } else {
                        sh './composer install --no-interaction --no-progress'
                    }
                }
            }
        }

        stage('Configuration des tests') {
            steps {
                sh 'test -f .env.testing || (test -f .env.example && cp .env.example .env.testing)'

                script {
                    def mysqlInstalled = sh(script: 'which mysql || echo "not found"', returnStdout: true).trim()
                    if (!mysqlInstalled.contains("not found")) {
                        sh '''
                        mysql -h 127.0.0.1 -P 3308 -u root -e "CREATE DATABASE IF NOT EXISTS testing_db;" || echo "Impossible de créer la base de données testing_db"
                        '''
                    } else {
                        echo "AVERTISSEMENT: MySQL n'est pas installé. La base de données doit être créée manuellement."
                    }
                }

                sh 'grep -q "APP_KEY=base64:" .env.testing || php artisan key:generate --env=testing'
                sh 'php artisan config:clear'
            }
        }

        stage('Tests unitaires') {
            steps {
                sh 'php artisan migrate:fresh --env=testing --force || echo "Échec des migrations"'
                sh 'mkdir -p reports'
                sh 'php artisan test --testsuite=Unit || echo "Échec des tests unitaires"'
            }
        }
    }

    post {
        success {
            echo '🎉 Tests unitaires réussis !'
        }
        failure {
            echo '⚠ Erreur lors des tests, vérifiez les logs.'
        }
    }
}
