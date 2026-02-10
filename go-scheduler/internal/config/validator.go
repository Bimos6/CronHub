package config

import (
    "log"
    "time"
)

func Validate(cfg *Config) {
    if cfg.ServiceKey == "" {
        log.Fatal("SERVICE_KEY is required")
    }
    if cfg.LaravelURL == "" {
        log.Fatal("LARAVEL_URL is required")
    }
    if cfg.RedisURL == "" {
        log.Fatal("REDIS_URL is required")
    }
    if cfg.Interval < 5*time.Second {
        log.Fatal("INTERVAL_SECONDS must be at least 5 seconds")
    }
}