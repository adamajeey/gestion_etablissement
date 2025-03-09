pipeline {
    agent any

    stages {
        stage('Récupération du code') {
            steps {
                checkout scm
            }
        }

        stage('Installation des dépendances') {
            agent {
                docker {
                    image 'composer:latest'
                    // Rend le répertoire de travail disponible à l'intérieur du conteneur
                    reuseNode true
                }
            }
            steps {
                sh 'composer install --no-interaction --no-progress'
            }
        }

        stage('Build du projet') {
            agent {
                docker {
                    image 'php:8.1-cli'
                    reuseNode true
                }
            }
            steps {
                sh 'php artisan key:generate'
                sh 'php artisan config:cache'
                sh 'php artisan route:cache'
            }
        }

        stage('Tests unitaires') {
            agent {
                docker {
                    image 'php:8.1-cli'
                    reuseNode true
                }
            }
            steps {
                sh 'vendor/bin/phpunit --log-junit tests-report.xml'
            }
        }

        stage('Tests IHM') {
            agent {
                docker {
                    image 'php:8.1-cli'
                    reuseNode true
                }
            }
            steps {
                sh 'php artisan dusk'
            }
        }

        stage('Analyse qualité') {
            steps {
                echo 'Exécution de l\'analyse de qualité du code'
                // Vous pouvez intégrer SonarQube ou d'autres outils ici
            }
        }

        stage('Packaging') {
            steps {
                echo 'Création du package d\'application'
                sh 'tar -czf application.tar.gz --exclude="./node_modules" --exclude="./vendor" --exclude="./.git" .'
            }
        }

        stage('Construction image Docker') {
            steps {
                echo 'Construction de l\'image Docker'
                sh 'docker build -t gestion-etablissement:${BUILD_NUMBER} .'
            }
        }

        stage('Publication des artefacts') {
            steps {
                echo 'Publication des artefacts vers le dépôt'
                // Commandes pour pousser l'image Docker vers un registre, par exemple
                // sh 'docker push votre-registre/gestion-etablissement:${BUILD_NUMBER}'
            }
        }

        stage('Déploiement') {
            steps {
                echo 'Déploiement de l\'application'
                // Commandes de déploiement vers votre environnement cible
            }
        }
    }

    post {
        always {
            cleanWs()
        }
        success {
            echo 'Pipeline exécuté avec succès!'
        }
        failure {
            echo 'Le pipeline a échoué!'
        }
    }
}
