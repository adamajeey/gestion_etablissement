pipeline {
    agent any

    stages {
        stage('Cloner le code') {
            steps {
                git branch: 'dev', url: 'https://github.com/adamajeey/gestion_etablissement.git'
            }
        }
    }

    post {
        success {
            echo '🎉 Clonage réussi !'
        }
        failure {
            echo '⚠ Erreur lors du clonage, vérifiez les logs.'
        }
    }
}
