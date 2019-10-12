## Test Assignment

### Bootstrapping 

- [install Docker](https://docs.docker.com/v17.09/engine/installation/)
- [add current user to docker group](https://docs.docker.com/install/linux/linux-postinstall//) for Linux users
- run:
```
cp .env.dist .env
docker-compose up
```
- execute migrations:
```
docker-compose exec php php bin/console doctrine:migrations:migrate
```
That's all! API is available at `localhost:777`:
```
curl  -d '{"title":"Classroom 1", "isActive":true}' -H "Content-Type: application/json" -X POST  -w " %{http_code}\n http://localhost:777/api/classrooms "
```
### Assigment
Сделать на Symfony 3.4 или Symfony 4+ небольшое REST API приложение для работы с сущностью Classroom, которое должно уметь:
1. Возвращать список классов
2. Возвращать 1 класс
3. Реализовывать CRUD
4. Изменять состояние класса (активный/не активный)

В процессе выполнения задания необходимо показать знания и навыки владения OOP, ORM Doctrine 2 и Symfony 3 (или 4) в целом.
Приветствуется применение новых возможностей последних версий Symfony (autowiring и т.п.).

Исходные данные - таблица с полями:
1. Идентификатор класса
2. Название класса
3. Дата создания класса
4. Активный да/нет

Решение необходимо представить в виде готового проекта, опубликованного на github, содержащего:
1. само приложение: контроллеры, сущности, репозитории, сервисы и т.д.
2. дамп БД
3. в readme проекта должны быть описаны шаги развертывания и любые ваши комментарии