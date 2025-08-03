pipeline {
      agent any
      stages {
          stage('Checkout') {
              steps {
                  git url: 'https://github.com/phatchamcom/library-management.git'
              }
          }
          stage('Build') {
              steps {
                  bat 'echo "Building..."'
              }
          }
          stage('Test') {
              steps {
                  bat 'C:\\php\\php.exe -l login.php'
              }
          }
          stage('Deploy') {
              steps {
                  bat '''
                      if not exist C:\\path\\to\\destination\\library mkdir C:\\path\\to\\destination\\library
                      xcopy . C:\\path\\to\\destination\\library /E /H /C /I /Y
                  '''
              }
          }
      }
      post {
          failure {
              echo 'Pipeline failed!'
          }
      }
  }
