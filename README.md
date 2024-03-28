# {PROJECT_NAME}

Краткое описание проекта

## Документация

[Документация находится здесь](documentation)

## Installation

```bash
git clone git@github.com:enterprise-it-ru/{PROJECT_NAME}.git {PROJECT_NAME}.local
cd {PROJECT_NAME}.local
composer install
```

Copy the .env file and change the database connection settings

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

```bash
npm install
```

```bash
npm run build
```

For development mode, use the command

```bash
npm run dev
```

## Установка в докере

Если нет make, то взять команды из makefile и выполнять напрямую

Запуск контейнера.

```bash
make up
```

Открыть консоль:

```
make shell
```

В консоли уже можно продолжить обычную установку с шага composer install
