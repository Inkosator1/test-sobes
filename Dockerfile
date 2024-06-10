FROM yiisoftware/yii2-php:8.2-apache

# Install MySQL client
RUN apt-get update && apt-get install -y default-mysql-client && rm -rf /var/lib/apt/lists/*
