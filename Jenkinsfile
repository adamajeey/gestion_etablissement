pipeline {
    agent any

    stages {
        stage('Vérification de l\'environnement') {
            steps {
                sh 'which php || echo "PHP not installed"'
                sh 'which composer || echo "Composer not installed"'
                sh 'which mysql || echo "MySQL client not installed"'
            }
        }

        stage('Installation des outils nécessaires') {
            steps {
                // Ces commandes supposent que vous êtes sur un système Debian/Ubuntu
                sh '''
                if ! which php > /dev/null; then
                    echo "Installation de PHP..."
                    sudo apt-get update
                    sudo apt-get install -y php php-cli php-mbstring php-xml php-zip php-mysql curl git unzip
                fi
                '''

                sh '''
                if ! which composer > /dev/null; then
                    echo "Installation de Composer..."
                    curl -sS https://getcomposer.org/installer | php
                    sudo mv composer.phar /usr/local/bin/composer
                    sudo chmod +x /usr/local/bin/composer
                fi
                '''

                sh '''
                if ! which mysql > /dev/null; then
                    echo "Installation du client MySQL..."
                    sudo apt-get install -y mysql-client
                fi
                '''
            }
        }

        stage('Cloner le code') {
            steps {
                git branch: 'main', url: 'https://github.com/adamajeey/gestion_etablissement.git'
            }
        }

        stage('Installation des dépendances') {
            steps {
                sh 'composer install --no-interaction --no-progress'
            }
        }

        stage('Configuration des tests') {
            steps {
                // Vérifie si .env.testing existe déjà
                sh 'test -f .env.testing || (test -f .env.example && cp .env.example .env.testing)'

                // Créer la base de données de test si elle n'existe pas
                sh '''
                mysql -h 127.0.0.1 -P 3308 -u root -e "CREATE DATABASE IF NOT EXISTS testing_db;"
                '''

                // Générer la clé d'application pour l'environnement de test s'il n'y en a pas
                sh 'grep -q "APP_KEY=" .env.testing && grep -q "APP_KEY=base64:" .env.testing || php artisan key:generate --env=testing'
                sh 'php artisan config:clear'
            }
        }

        stage('Tests unitaires') {
            steps {
                // Exécution des migrations dans l'environnement de test
                sh 'php artisan migrate:fresh --env=testing --force'

                // Exécution des tests unitaires
                sh 'mkdir -p reports'
                sh 'php artisan test --testsuite=Unit'
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
