pipeline {
           agent any
           stages {
               stage('Checkout') {
                   steps {
                       git 'https://github.com/phatchamcom/library-management.git' // Thay bằng URL repo của bạn
                   }
               }
               stage('Build') {
                   steps {
                       bat 'echo "Building..."'
                       // Thêm lệnh build nếu cần (ví dụ: composer install cho PHP)
                   }
               }
               stage('Test') {
                   steps {
                       bat 'php -l *.php' // Kiểm tra cú pháp PHP
                       // Thêm unit test nếu có (sử dụng PHPUnit)
                   }
               }
               stage('Deploy') {
                   steps {
                       bat 'cp -r . /var/www/html/library' // Triển khai lên thư mục web server
                   }
               }
           }
           post {
               success {
                   echo 'Pipeline completed successfully!'
               }
               failure {
                   echo 'Pipeline failed!'
               }
           }
       }
