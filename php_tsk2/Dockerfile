FROM php:7.4-apache


RUN apt-get update && apt-get install -y \
    git \
    && rm -rf /var/lib/apt/lists/*


EXPOSE 80

CMD ["php", "-S", "localhost:8000"]
