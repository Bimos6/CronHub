# ⏰ CronHub - Система планирования HTTP-запросов

## 🚀 Быстрый старт

### Вариант 1: С Docker Compose

```bash
# Клонирование репозитория
git clone https://github.com/Bimos6/CronHub.git
cd CronHub

# Запуск всех сервисов
docker compose up -d --build

# Проверка статуса
docker compose ps

#Админка
http://localhost:8000/admin
```
### Вариант 2: С Make

```bash
# Установите make если нет
# Ubuntu/Debian: sudo apt-get install make
# macOS: brew install make
# Windows: установите через Chocolatey или WSL

# Клонирование репозитория
git clone https://github.com/Bimos6/CronHub.git
cd CronHub

#Билд контейнеров
make build
#Запуск
make up

#Админка
http://localhost:8000/admin
```
