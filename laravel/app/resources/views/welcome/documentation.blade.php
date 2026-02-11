<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header bg-gradient bg-primary text-white">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/go/go-original.svg" width="30" class="me-2" style="filter: brightness(0) invert(1);">
                    CronHub - Система планирования HTTP-запросов
                </h4>
                <span class="badge bg-light text-dark">
                    <i class="fab fa-golang me-1"></i> Go 1.18+
                </span>
            </div>
        </div>
        <div class="card-body">
            
            <!-- Hero Section -->
            <div class="row mb-5">
                <div class="col-md-8">
                    <h5>🎯 О проекте</h5>
                    <p class="lead">
                        Высокопроизводительная система для планирования и выполнения HTTP-запросов 
                        на <strong>Go</strong> с веб-интерфейсом на <strong>Laravel</strong>.
                    </p>
                    <p>
                        Проект демонстрирует микросервисную архитектуру, конкурентную обработку задач 
                        и взаимодействие между сервисами через Redis очередь.
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="card bg-dark text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-tachometer-alt fa-3x mb-3"></i>
                            <h6>Статус системы</h6>
                            <div class="d-flex justify-content-center gap-3 mt-2">
                                <span class="badge bg-success">Scheduler: ✅</span>
                                <span class="badge bg-success">Worker: ✅ (3)</span>
                                <span class="badge bg-info">Redis: ✅</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Go Микросервисы -->
            <div class="mb-5">
                <h5 class="border-bottom pb-2">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/go/go-original.svg" width="25" class="me-2">
                    Go Микросервисы
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-header bg-primary bg-gradient text-white">
                                <strong><i class="fas fa-clock me-2"></i> Go Scheduler (Планировщик)</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-3">
                                    <li>Опрашивает API Laravel каждые 60 секунд</li>
                                    <li>Находит задачи с истекшим <code>next_run_at</code></li>
                                    <li>Помещает задачи в Redis очередь</li>
                                    <li>Обновляет время следующего запуска</li>
                                </ul>
                                <div class="bg-light p-2 rounded">
                                    <small><strong>Технологии:</strong> net/http, viper, zap-логирование</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success bg-gradient text-white">
                                <strong><i class="fas fa-tasks me-2"></i> Go Worker Pool (Исполнитель)</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-3">
                                    <li><strong>3 параллельных воркера</strong> (горутины)</li>
                                    <li>Читают задачи из Redis очереди</li>
                                    <li>Выполняют HTTP-запросы (GET/POST/PUT/DELETE)</li>
                                    <li>Обрабатывают таймауты и повторные попытки</li>
                                    <li>Отправляют результаты в Laravel API</li>
                                </ul>
                                <div class="bg-light p-2 rounded">
                                    <small><strong>Технологии:</strong> goroutines, channels, http.Client, redis/go-redis</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Архитектура -->
            <div class="mb-5">
                <h5 class="border-bottom pb-2">
                    <i class="fas fa-sitemap me-2"></i>
                    Архитектура системы
                </h5>
                <div class="text-center mb-4">
                    <pre style="background: #2d2d2d; color: #f8f8f2; padding: 20px; border-radius: 8px; font-family: monospace; text-align: left; max-width: 100%; overflow-x: auto;">
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   Laravel API   │     │   Go Scheduler  │     │   Go Worker     │
│   (Админка)     │◄────┤   (Планировщик) │────►│   (Исполнитель) │
│   localhost:8000│     │   Интервал: 60с │     │   Воркеров: 3   │
└────────┬────────┘     └─────────────────┘     └────────┬────────┘
         │                                                │
         │ PostgreSQL                                     │ Redis
         │ (хранилище)                                    │ (очередь)
         ▼                                                ▼
┌─────────────────┐                             ┌─────────────────┐
│    Таблицы:     │                             │   job_queue     │
│   - jobs        │                             │   List (BRPOP)  │
│   - executions  │                             └─────────────────┘
│   - users       │
└─────────────────┘
                    </pre>
                </div>
            </div>
            
            <!-- Технологический стек -->
            <div class="mb-5">
                <h5 class="border-bottom pb-2">
                    <i class="fas fa-cogs me-2"></i>
                    Технологический стек
                </h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-body text-center p-3">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/go/go-original.svg" width="40" class="mb-2">
                                <h6>Go 1.18+</h6>
                                <small class="text-muted">Микросервисы</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-body text-center p-3">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/redis/redis-original.svg" width="40" class="mb-2">
                                <h6>Redis</h6>
                                <small class="text-muted">Очередь задач</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-body text-center p-3">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg" width="40" class="mb-2">
                                <h6>PostgreSQL</h6>
                                <small class="text-muted">База данных</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-body text-center p-3">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-plain.svg" width="40" class="mb-2">
                                <h6>Laravel 10</h6>
                                <small class="text-muted">Веб-интерфейс</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="bg-light p-3 rounded">
                            <strong>Инфраструктура:</strong> Docker, Docker Compose, Makefile, GitHub Actions
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Сущности БД -->
            <div class="mb-5">
                <h5 class="border-bottom pb-2">
                    <i class="fas fa-database me-2"></i>
                    Основные сущности
                </h5>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Сущность</th>
                            <th>Описание</th>
                            <th>Ключевые поля</th>
                            <th>Связи</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Job</strong></td>
                            <td>Задача для выполнения</td>
                            <td><code>name, url, method, cron_expression, is_active</code></td>
                            <td>belongs_to User, has_many Executions</td>
                        </tr>
                        <tr>
                            <td><strong>Execution</strong></td>
                            <td>Результат выполнения</td>
                            <td><code>status_code, response_body, started_at, finished_at</code></td>
                            <td>belongs_to Job</td>
                        </tr>
                        <tr>
                            <td><strong>User</strong></td>
                            <td>Пользователь системы</td>
                            <td><code>name, email, password_hash</code></td>
                            <td>has_many Jobs</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Cron выражения -->
            <div class="mb-5">
                <h5 class="border-bottom pb-2">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Расписание (Cron выражения)
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <p class="mb-2"><strong>Формат:</strong> <code>* * * * *</code></p>
                            <p class="mb-0 small">
                                ┌───────────── минута (0-59)<br>
                                │ ┌───────────── час (0-23)<br>
                                │ │ ┌───────────── день месяца (1-31)<br>
                                │ │ │ ┌───────────── месяц (1-12)<br>
                                │ │ │ │ ┌───────────── день недели (0-6)<br>
                                │ │ │ │ │<br>
                                * * * * *
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr><td><code>* * * * *</code></td><td>Каждую минуту</td></tr>
                            <tr><td><code>*/5 * * * *</code></td><td>Каждые 5 минут</td></tr>
                            <tr><td><code>0 * * * *</code></td><td>Каждый час</td></tr>
                            <tr><td><code>0 0 * * *</code></td><td>Раз в день</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- API Endpoints -->
            <div class="mb-4">
                <h5 class="border-bottom pb-2">
                    <i class="fas fa-plug me-2"></i>
                    API Endpoints (Go ↔ Laravel)
                </h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Метод</th>
                            <th>Endpoint</th>
                            <th>Описание</th>
                            <th>Доступ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-success">GET</span></td>
                            <td><code>/api/v1/jobs/due</code></td>
                            <td>Получить просроченные задачи</td>
                            <td><code>X-Service-Key</code></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-warning text-dark">POST</span></td>
                            <td><code>/api/v1/executions</code></td>
                            <td>Сохранить результат выполнения</td>
                            <td><code>X-Service-Key</code></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-primary">CRUD</span></td>
                            <td><code>/api/v1/jobs</code></td>
                            <td>Управление задачами</td>
                            <td>JWT (auth:sanctum)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Статус разработки -->
            <div class="alert alert-info border">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="fas fa-code-branch fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="alert-heading">🚧 Проект в активной разработке</h6>
                        <p class="mb-0">
                            Стек: <strong>Go (scheduler + worker)</strong> + Laravel + PostgreSQL + Redis.<br>
                            Планируется: интеграция с ClickHouse, улучшение observability, Grafana дашборды.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.card {
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.card-header {
    font-weight: 500;
}
code {
    background: #f8f9fa;
    padding: 2px 5px;
    border-radius: 4px;
    color: #d63384;
}
.badge {
    font-size: 12px;
    padding: 5px 10px;
}
</style>