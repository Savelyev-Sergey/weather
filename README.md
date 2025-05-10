# weather

Приложение (для пользователя) состоит из одного контроллера, 
который предоставляет данные погоды на сегодняшний день. 

Успешный `http://localhost:8899/weather/London`
Неуспешный `http://localhost:8899/weather`
Неуспешный `http://localhost:8899/weather/Lon`

Также есть команда, которая собирает данные.

Разобрался с API стороннего сервиса до получения временного ключа.
Предполагается, что запуск команды будет происходить по крону раз в сутки.
Данные будут храниться в БД.
Поиск данных погоды происходит только по городу.

На основе файла .env нужно создать файл .env.local

1. Запуск Docker `docker-compose up -d`
2. Зайти в контейнер `docker-compose exec php-fpm sh`
3. Установить зависимости `composer install`
4. Выполнить миграции `php bin/console doctrine:migrations:migrate`
5. Запустить фикстуры `php bin/console doctrine:fixtures:load`

6. Тестовая база данных (шаги 7 и 8, 9)
7. `php bin/console --env=test doctrine:database:create`
8. `php bin/console --env=test doctrine:schema:create`
9. `php bin/console --env=test doctrine:fixtures:load`
10. Запуск тестов `php bin/phpunit`
11. Для получения данных из удаленного сервиса есть консольная команда
12. `php bin/console app:get-weather`
