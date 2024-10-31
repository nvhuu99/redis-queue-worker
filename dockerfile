FROM ubuntu:20.04

USER root

# Set timezone
RUN ln -snf "/usr/share/zoneinfo/Asia/Ho_Chi_Minh" "/etc/localtime" && echo "Asia/Ho_Chi_Minh" > "/etc/timezone"

# Update package and install necessary tools
RUN apt-get update && apt-get install -y git vim wget curl gnupg software-properties-common
RUN add-apt-repository ppa:ondrej/php -y \
    && apt-get update && apt-get install -y \
        php8.1 php8.1-cli php8.1-common php8.1-fpm php8.1-dev php8.1-xml php8.1-mbstring php-pear \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
WORKDIR /home/root
RUN wget https://getcomposer.org/download/2.5.7/composer.phar
RUN chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

# Install Swoole
RUN git clone https://github.com/swoole/swoole-src.git
WORKDIR /home/root/swoole-src
RUN phpize && ./configure && make && make install
RUN echo "extension=swoole" >> /etc/php/8.1/cli/php.ini

CMD ["tail", "-f", "/dev/null"]
