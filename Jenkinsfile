 pipeline {
     agent any

     stages {
         stage('Récupération du code') {
             steps {
                 // Récupération du code depuis votre SCM
                 checkout scm
             }
         }

         stage('Installation des dépendances') {
             steps {
                 // Installation des dépendances Laravel
                 sh 'composer install --no-interaction --no-progress'
                 sh 'npm install'
             }
         }

         stage('Build du projet') {
             steps {
                 // Compilation des assets
                 sh 'npm run production'
             }
         }

         stage('Tests unitaires') {
             steps {
                 // Exécution des tests Laravel
                 sh 'php artisan test --testsuite=Unit'
             }
         }

         stage('Tests IHM') {
             steps {
                 // Exécution des tests du front
                 sh 'php artisan dusk'
             }
         }

         stage('Analyse qualité') {
             steps {
                 // Analyse avec SonarQube
                 withSonarQubeEnv('SonarQube') {
                     sh 'sonar-scanner'
                 }
             }
         }

         stage('Packaging') {
             steps {
                 // Création de l'artéfact
                 sh 'tar -czf application.tar.gz --exclude=node_modules --exclude=vendor .'
                 archiveArtifacts artifacts: 'application.tar.gz', fingerprint: true
             }
         }

         stage('Construction image Docker') {
             steps {
                 // Création de l'image Docker
                 sh 'docker build -t gestion-etablissement:${BUILD_NUMBER} .'
             }
         }

         stage('Publication des artefacts') {
             steps {
                 // Dépôt des artefacts selon l'environnement
                 script {
                     if (env.BRANCH_NAME == 'adama') {
                         // Pour dev et staging
                         sh 'docker tag gestion-etablissement:${BUILD_NUMBER} localhost:5000/gestion-etablissement:${BUILD_NUMBER}'
                         sh 'docker push localhost:5000/gestion-etablissement:${BUILD_NUMBER}'
                     } else if (env.BRANCH_NAME == 'main') {
                         // Pour preprod et prod
                         sh 'docker tag gestion-etablissement:${BUILD_NUMBER} registry.example.com/gestion-etablissement:${BUILD_NUMBER}'
                         sh 'docker push registry.example.com/gestion-etablissement:${BUILD_NUMBER}'
                     }
                 }
             }
         }

         stage('Déploiement') {
             steps {
                 script {
                     if (env.BRANCH_NAME == 'adama') {
                         // Déploiement sur Docker pour Dev
                         sh 'docker-compose -f docker-compose.dev.yml up -d'
                     } else if (env.BRANCH_NAME == 'staging') {
                         // Déploiement sur K8s pour Staging
                         sh 'kubectl apply -f k8s/staging/'
                     } else if (env.BRANCH_NAME == 'main') {
                         // Déploiement sur cloud pour Prod
                         sh 'kubectl apply -f k8s/production/'
                     }
                 }
             }
         }
     }

     post {
         always {
             // Nettoyage
             cleanWs()
         }
     }
 }
