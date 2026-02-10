<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📋 Cron Task Manager - Документация</h4>
        </div>
        <div class="card-body">
            
            <div class="mb-4">
                <h5>🎯 О проекте</h5>
                <p>
                    Веб-система для управления cron-задачами. Позволяет создавать, мониторить 
                    и управлять HTTP-запросами по расписанию через удобный интерфейс.
                </p>
            </div>
            
            <div class="mb-4">
                <h5>📦 Архитектура</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-light">
                                <strong>Laravel микросервис</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>API для управления задачами</li>
                                    <li>PostgreSQL база данных</li>
                                    <li>JWT аутентификация</li>
                                    <li>Админ-панель Orchid</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success mb-3">
                            <div class="card-header bg-light">
                                <strong>Python микросервисы</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>Scheduler - планировщик задач</li>
                                    <li>Worker - исполнитель HTTP-запросов</li>
                                    <li>Redis очередь</li>
                                    <li>Celery для фоновых задач</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h5>⚙️ Основные сущности</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Сущность</th>
                            <th>Описание</th>
                            <th>Поля</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Job</strong></td>
                            <td>Задача для выполнения</td>
                            <td>name, url, cron, method, is_active</td>
                        </tr>
                        <tr>
                            <td><strong>Execution</strong></td>
                            <td>Результат выполнения</td>
                            <td>status_code, duration_ms, started_at</td>
                        </tr>
                        <tr>
                            <td><strong>User</strong></td>
                            <td>Пользователь системы</td>
                            <td>email, name, password (hash)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mb-4">
                <h5>📅 Расписание (Cron выражения)</h5>
                <div class="alert alert-info">
                    <p class="mb-2">Формат: <code>* * * * *</code></p>
                    <p class="mb-0">
                        <small>
                        ┌───────────── минута (0-59)<br>
                        │ ┌───────────── час (0-23)<br>
                        │ │ ┌───────────── день месяца (1-31)<br>
                        │ │ │ ┌───────────── месяц (1-12)<br>
                        │ │ │ │ ┌───────────── день недели (0-6, 0=воскресенье)<br>
                        │ │ │ │ │<br>
                        * * * * *
                        </small>
                    </p>
                </div>
                <table class="table table-sm">
                    <tr><td><code>* * * * *</code></td><td>Каждую минуту</td></tr>
                    <tr><td><code>0 * * * *</code></td><td>Каждый час</td></tr>
                    <tr><td><code>0 0 * * *</code></td><td>Раз в день (полночь)</td></tr>
                    <tr><td><code>*/15 * * * *</code></td><td>Каждые 15 минут</td></tr>
                </table>
            </div>
            
            <div class="mb-4">
                <h5>🔐 Безопасность</h5>
                <ul>
                    <li>JWT токены для API доступа</li>
                    <li>Хэширование паролей (bcrypt)</li>
                    <li>Валидация URL (запрет localhost/private IP)</li>
                    <li>Rate limiting для API</li>
                    <li>HTTPS обязателен в production</li>
                </ul>
            </div>
            
            <div class="alert alert-light border">
                <h6 class="alert-heading">ℹ️ Статус</h6>
                <p class="mb-0">
                    Проект в активной разработке.
                </p>
            </div>
        </div>
    </div>
</div>