package config

import "log"

func Log(cfg *Config) {
    log.Println("Config loaded:")
    log.Printf("   Laravel: %s", cfg.LaravelURL)
    log.Printf("   Redis: %s", cfg.RedisURL)
    log.Printf("   Queue: %s", cfg.QueueName)
    log.Printf("   Interval: %v", cfg.Interval)
    
    if len(cfg.ServiceKey) > 4 {
        log.Printf("   ServiceKey: %s...%s", 
            cfg.ServiceKey[:2], cfg.ServiceKey[len(cfg.ServiceKey)-2:])
    } else {
        log.Printf("   ServiceKey: ***")
    }
}