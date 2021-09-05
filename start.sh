#!/usr/bin/env bash

echo 'Обновляем composer'
echo  '\n'
./composer.phar install
echo  '\n'
echo 'Запускаем создание базы'
echo  '\n'
bin/console doctrine:database:create
echo  '\n'
echo "Обновляем базу! "
echo  '\n'
bin/console d:s:u -f
echo 'Запускаем сервер'
symfony server:start -d
echo 'Загрузим данные по ценам за последние 24 часа'
bin/console app:load-history 24
echo  '\n'
echo  "Готово"