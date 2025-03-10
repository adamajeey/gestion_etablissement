pipeline {
    agent {
        docker {
            image 'php:8.2-cli'
            args '-v /var/jenkins_home/.composer:/root/.composer'
        }
    }

    stages {
        stage('Vérification de PHP') {
            steps {
                sh 'php -v' // Vérifie que PHP est bien installé
            }
        }

        stage('Installation des outils') {
            steps {
                sh 'apt-get update'
                sh 'apt-get install -y git unzip libzip-dev'
                sh 'docker-php-ext-install zip'
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

        stage('Configuration des tests') {
            steps {
                // Créer un fichier .env.testing s'il n'existe pas
                sh 'test -f .env.testing || cp .env.example .env.testing'

                // Configurer la base de données pour les tests (utiliser SQLite en mémoire)
                sh '''
                sed -i "s/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/g" .env.testing
                sed -i "s/DB_DATABASE=.*/DB_DATABASE=:memory:/g" .env.testing
                '''

                // Générer la clé d'application pour l'environnement de test
                sh 'php artisan key:generate --env=testing'
                sh 'php artisan config:clear'
            }
        }

        stage('Tests unitaires') {
            steps {
                // Installation de SQLite et activation de PDO SQLite
                sh 'apt-get install -y sqlite3 libsqlite3-dev'
                sh 'docker-php-ext-install pdo_sqlite'

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
