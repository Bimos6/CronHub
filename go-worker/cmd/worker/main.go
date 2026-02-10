package main

import (
    "context"
    "os"
    "os/signal"
    "syscall"
    
    "go-worker/internal/config"
    "go-worker/internal/queue"
    "go-worker/internal/processor"
    "go-worker/internal/worker"
    "go.uber.org/zap"
)

func main() {
    logger, _ := zap.NewProduction()
    defer logger.Sync()
    
    logger.Info("Starting Go Worker...")
    
    cfg := config.Load()
    
    redisQueue, err := queue.NewRedisQueue(cfg.RedisURL, cfg.QueueName)
    if err != nil {
        logger.Fatal("Failed to connect to Redis", zap.Error(err))
    }
    
    proc := processor.NewProcessor(logger)
    
    w := worker.NewWorker(redisQueue, proc, cfg.Workers, logger)
    
    ctx, cancel := context.WithCancel(context.Background())
    defer cancel()
    
    sigChan := make(chan os.Signal, 1)
    signal.Notify(sigChan, os.Interrupt, syscall.SIGTERM)
    
    w.Start(ctx)
    
    <-sigChan
    logger.Info("Shutdown signal received")
    
    cancel()
    w.Stop()
    
    logger.Info("Worker stopped gracefully")
}