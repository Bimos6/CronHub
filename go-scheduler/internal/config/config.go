package config

import "time"

type Config struct {
    LaravelURL  string        `mapstructure:"LARAVEL_URL"`
    ServiceKey  string        `mapstructure:"SERVICE_KEY"`
    
    RedisURL    string        `mapstructure:"REDIS_URL"`
    QueueName   string        `mapstructure:"QUEUE_NAME"`
    
    Interval    time.Duration `mapstructure:"INTERVAL_SECONDS"`
    Timeout     time.Duration `mapstructure:"TIMEOUT_SECONDS"`
    
    LogLevel    string        `mapstructure:"LOG_LEVEL"`
}