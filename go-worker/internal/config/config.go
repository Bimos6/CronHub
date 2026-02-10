package config

import (
    "github.com/spf13/viper"
)

type Config struct {
    RedisURL   string
    QueueName  string
    Workers    int
    Timeout    int
    MaxRetries int
}

func Load() *Config {
    viper.SetDefault("REDIS_URL", "redis://redis:6379")
    viper.SetDefault("QUEUE_NAME", "job_queue")
    viper.SetDefault("WORKERS", 3)
    viper.SetDefault("TIMEOUT_SECONDS", 30)
    viper.SetDefault("MAX_RETRIES", 3)
    
    viper.AutomaticEnv()
    
    return &Config{
        RedisURL:   viper.GetString("REDIS_URL"),
        QueueName:  viper.GetString("QUEUE_NAME"),
        Workers:    viper.GetInt("WORKERS"),
        Timeout:    viper.GetInt("TIMEOUT_SECONDS"),
        MaxRetries: viper.GetInt("MAX_RETRIES"),
    }
}