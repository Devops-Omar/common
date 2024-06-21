# Use the official PHP image with Apache
FROM php:7.4-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Expose port 80
EXPOSE 80

# Enable Apache mod_rewrite (optional, but useful for many PHP applications)
RUN a2enmod rewrite

# Start Apache in the foreground (this keeps the container running)
CMD ["apache2-foreground"]
