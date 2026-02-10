package config

import (
    "github.com/spf13/viper"
)

type Config struct {
    RedisURL   string `mapstructure:"REDIS_URL"`
    QueueName  string `mapstructure:"QUEUE_NAME"`
    Workers    int    `mapstructure:"WORKERS"`
    Timeout    int    `mapstructure:"TIMEOUT_SECONDS"`
    MaxRetries int    `mapstructure:"MAX_RETRIES"`
}

func Load() *Config {
    viper.SetDefault("REDIS_URL", "redis://localhost:6379")
    viper.SetDefault("QUEUE_NAME", "job_queue")
    viper.SetDefault("WORKERS", 5)
    viper.SetDefault("TIMEOUT_SECONDS", 30)
    viper.SetDefault("MAX_RETRIES", 3)
    
    viper.SetConfigFile(".env")
    viper.AutomaticEnv()
    viper.ReadInConfig()
    
    cfg := &Config{}
    viper.Unmarshal(cfg)
    
    return cfg
}