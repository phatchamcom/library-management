pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                git 'https://your-git-repo-url.git'
            }
        }
        stage('Build') {
            steps {
                sh 'npm install' // Hoặc lệnh build tương ứng (ví dụ: mvn build cho Java)
                sh 'npm run build' // Nếu là dự án web
            }
        }
        stage('Test') {
            steps {
                sh 'npm test' // Chạy unit test hoặc các test tự động
            }
        }
        stage('Deploy') {
            steps {
                // Ví dụ: triển khai lên server
                sh 'scp -r ./build/* user@server:/path/to/webroot'
            }
        }
    }
    post {
        always {
            archiveArtifacts artifacts: 'build/**', allowEmptyArchive: true
            cleanWs() // Dọn dẹp workspace sau khi chạy
        }
    }
}
