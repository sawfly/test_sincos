# test_sincos
## task
1) Зробити реєстрацію на сайті (пошта, логін, пароль)
2) Вхід в особистий кабінет (логін, пароль)
3) В особистому кабінеті має бути кнопка - згенерувати ссилку. Коли юзер на неї натискає, створюється посилання при 
переході по якому не зареєстрований юзер може зареєструватись і після реєстрацію у юзера який згенерував цю ссилку в 
особистому кабінеті з'являється в списку пошта і логін юзера чи юзерів які зареєстувались по цій ссилці та час 
реєстрації.
4) Так само коли юзер зареєстувався по ссилці то в особистому кабінеті має бути написано,
що ви запрошені таким то і таким то.
5) Коли юзер в особистому кабінеті натискає знову згенерувати ссилку то силка має змінитись, але стара силка повинна 
діяти ще добу (для перевірки можна і 60 секунд поставити). 

## deploy
1) `docker-compose up -d`
2) `docker exec -ti testsincos.app bash` - Run app container
3) `composer update`
4) `exit`
5) `docker inspect testsincos.app`. Find (e.g. "Gateway": "172.26.0.1",);
6) Add line `172.26.0.1 testsincos.app` into hosts.
7) Update .env to .env.example.
8) Run in app container `chown www-data:www-data -R storage/logs/` for debug error trace
9) Run in app container `chown www-data:www-data -R storage/framework/` for debug error trace

## utilizing
1) Run in app container php artisan migrate