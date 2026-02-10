# CronHub - Система планирования HTTP-запросов

## 🚀 Быстрый старт

### Вариант 1: С Docker Compose (рекомендуется)
# Клонирование репозитория
git clone <repository-url>
cd CronHub

# Запуск всех сервисов
docker compose up -d --build

# Остановка
docker compose down

# Просмотр логов
docker compose logs -f

### Вариант 2: С Make
# Установите make если нет
# Ubuntu/Debian: sudo apt-get install make
# macOS: brew install make
# Windows: установите через Chocolatey или WSL

# Клонирование
git clone <repository-url>
cd CronHub

# Запуск
make up

# Остановка
make down

# Статус контейнеров
make status

# Просмотр логов
make logs