# Laravel Homework

## Задачи по БД

:white_check_mark: Связь многие ко многим (tag_post)
:white_check_mark: Связь один к одному (comment->user)
:white_check_mark: Связь один ко многим (post->comment)
:white_check_mark: Миграции

## Задачи по сценариям интерактивного контента

:white_check_mark: JS фреймоврк с реактивностью (VueJs)
:white_check_mark: backend фреймоврк laravel 8

## Общие заметки
### Роутинг

метод авторизации - session
| Метод | Маршрут | Описание |
|----------------|:---------:|:----------------:|
|post |/api/users/login|для авторизации|
|get|/api/users/authorized|вернуть пользователя если авторизованы|
|post|/api/posts/get|Вернуть посты|
|get|/api/tags|Вернуть созданные теги|
|post|/api/comments|Вернуть комментарии к посту|
|get|/api/users|Вернуть пользователей|
|get|/api/users/{user}|Вернуть пользователя|
|post|/api/users|Создать пользователя|
|put|/api/users/{user}|Изменить пользователя|
|delete|/api/users/{user}|Удалить пользователя|
|post|/api/users/logout |Разлогиниться|
|post|/api/posts|Создать пост|
|put|/api/comments|Создать коммент|