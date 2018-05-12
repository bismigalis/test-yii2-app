Инструкция по установке
=======================
 
1. установить composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

2. установить зависимости
composer install

3. залить дамп БД
mysql -u root -p yii2basic < test_db.sql
 
4. провести миграции командой
php yii migrate
 
5. запустить web-сервер командой
php yii serve
