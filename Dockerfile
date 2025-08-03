FROM openjdk:11-jre-slim WORKDIR /app COPY target/your-app.jar /app/your-app.jar EXPOSE 8080 CMD ["java", "-jar", "your-app.jar"]
