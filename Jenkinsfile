pipeline {
    agent any

    stages {
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
