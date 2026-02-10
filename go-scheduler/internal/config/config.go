package config

import (
    "strconv"
    "time"
    
    "github.com/spf13/viper"
)

type Config struct {
    LaravelURL string
    ServiceKey string
    RedisURL   string
    QueueName  string
    Interval   time.Duration
}

func Load() *Config {
    setupViper()
    
    cfg := &Config{
        LaravelURL: viper.GetString("LARAVEL_URL"),
        ServiceKey: viper.GetString("SERVICE_KEY"),
        RedisURL:   viper.GetString("REDIS_URL"),
        QueueName:  viper.GetString("QUEUE_NAME"),
    }
    
    cfg.loadInterval()
    return cfg
}

func setupViper() {
    viper.SetDefault("LARAVEL_URL", "http://localhost:8000")
    viper.SetDefault("REDIS_URL", "redis://localhost:6379")
    viper.SetDefault("QUEUE_NAME", "job_queue")
    viper.SetDefault("INTERVAL_SECONDS", 60)
    viper.SetDefault("SERVICE_KEY", "")
    
    viper.SetConfigFile(".env")
    viper.AutomaticEnv()
    viper.ReadInConfig()
}

func (c *Config) loadInterval() {
    intervalStr := viper.GetString("INTERVAL_SECONDS")
    if interval, err := strconv.Atoi(intervalStr); err == nil && interval > 0 {
        c.Interval = time.Duration(interval) * time.Second
    } else {
        c.Interval = 60 * time.Second
    }
}