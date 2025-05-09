# weather

Приложение (для пользователя) состоит из одного контроллера, 
который предоставляет данные погоды на сегодняшний день. 

Успешный `http://localhost:8899/weather/London`
Неуспешный `http://localhost:8899/weather`
Неуспешный `http://localhost:8899/weather/Lon`

Также есть команда, которая собирает данные по крону.

Разобрался с API стороннего сервиса до получения временного ключа.
Взял за константу, что данные получаем по крону,
из консольной команды раз в сутки(это можно гибко менять).
По ключевым аспектам привел к БД.
Акцентировал внимание на работу с городом (это по индексам),
страну оставил в тени. Думаю в рамках этого ТЗ не столь весомо.

На основе файла .env нужно создать файл .env.local
Все содержимое заменить на 
APP_ENV=dev
APP_DEBUG=1

1. Запуск Docker `docker-compose up -d`
2. Зайти в контейнер `docker-compose exec php-fpm sh`
3. Установить зависимости `composer install`
4. Выполнить миграции `php bin/console doctrine:migrations:migrate`
5. Запустить фикстуры `php bin/console doctrine:fixtures:load`

6. Тестовая база данных (шаги 7 и 8)
7. `php bin/console --env=test doctrine:database:create`
8. `php bin/console --env=test doctrine:schema:create`
9. `php bin/console --env=test doctrine:fixtures:load`
10. Запуск тестов `php bin/phpunit`
11. Для получения данных из удаленного сервиса есть консольная команда
12. `php bin/console app:get-weather`
