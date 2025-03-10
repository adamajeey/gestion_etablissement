pipeline {
    agent any

    stages {
        stage('Vérification de PHP') {
            steps {
                sh 'php -v' // Vérifie que PHP est bien installé
            }
        }

        stage('Installation de Composer') {
            steps {
                sh 'curl -sS https://getcomposer.org/installer | php'
                sh 'mv composer.phar /usr/local/bin/composer'
                sh 'chmod +x /usr/local/bin/composer'
                sh 'composer -V' // Vérifie l'installation de Composer
            }
        }

        stage('Cloner le code') {
            steps {
                git branch: 'main', url: 'https://github.com/adamajeey/gestion_etablissement.git'
            }
        }

        stage('Installation des dépendances') {
            steps {
                // Installation des dépendances PHP via Composer
                sh 'composer install --no-interaction --no-progress'
            }
        }

        stage('Tests unitaires') {
            steps {
                // Préparation de l'environnement de test
                sh 'cp .env.testing .env.testing.backup || true'
                sh 'php artisan key:generate' // Générer la clé d'application

                // Configuration de la base de données de test
                sh 'php artisan config:clear'
                sh 'php artisan migrate:fresh --env=testing --force'

                // Exécution des tests unitaires
                sh 'mkdir -p reports'
                sh 'php artisan test --testsuite=Unit'
            }
            post {
                always {
                    // Restauration du fichier .env.testing d'origine s'il existait
                    sh 'if [ -f .env.testing.backup ]; then mv .env.testing.backup .env.testing; fi'
                }
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
