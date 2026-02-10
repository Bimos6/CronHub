package main

import (
    "context"
    "log"
    "os"
    "os/signal"
    "syscall"
    "time"
    
    "cron-scheduler/internal/config"
    "cron-scheduler/internal/client"
    "cron-scheduler/internal/queue"
    "cron-scheduler/internal/scheduler"
)

func main() {
    log.Println("Starting Go Scheduler...")
    
    cfg := config.Load()
    
    laravelClient := api.NewLaravelClient(cfg)
    redisQueue, err := queue.NewRedisQueue(cfg)
    if err != nil {
        log.Fatalf("Failed to connect to Redis: %v", err)
    }
    
    sched := scheduler.New(laravelClient, redisQueue, cfg.Interval)
    
    ctx, cancel := context.WithCancel(context.Background())
    defer cancel()
    
    sigChan := make(chan os.Signal, 1)
    signal.Notify(sigChan, os.Interrupt, syscall.SIGTERM)
    
    go func() {
        if err := sched.Run(ctx); err != nil {
            log.Printf("Scheduler error: %v", err)
        }
    }()
    
    <-sigChan
    log.Println("Shutdown signal received")
    cancel()
    
    select {
    case <-time.After(2 * time.Second):
        log.Println("Shutdown timeout")
    }
}