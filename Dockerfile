# Sử dụng base image nhẹ chứa JRE 11
FROM openjdk:11-jre-slim

# Tạo thư mục làm việc trong container
WORKDIR /app

# Copy file .jar từ thư mục build của host vào container
COPY target/my-app.jar /app/my-app.jar

# Mở cổng 8080 (hoặc cổng khác nếu app dùng cổng khác)
EXPOSE 8085

# Lệnh

