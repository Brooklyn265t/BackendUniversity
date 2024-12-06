для перехода в php нужно
localhost/php/index.php

  database:
    image: mysql:8
    volumes:
      - ./Mysql:/docker-entrypoint-initdb.d/
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: coffeeprice
      MYSQL_USER: user
      MYSQL_PASSWORD: password
      UPLOAD_LIMIT: 16M
    ports:
    - "3306:3306"