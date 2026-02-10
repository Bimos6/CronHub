package scheduler

import (
    "context"
    "log"
    "time"
    
    "cron-scheduler/internal/client"
    "cron-scheduler/internal/queue"
)

type Scheduler struct {
    apiClient   *api.LaravelClient
    redisQueue  *queue.RedisQueue
    interval    time.Duration
}

func New(apiClient *api.LaravelClient, redisQueue *queue.RedisQueue, interval time.Duration) *Scheduler {
    return &Scheduler{
        apiClient:  apiClient,
        redisQueue: redisQueue,
        interval:   interval,
    }
}

func (s *Scheduler) Run(ctx context.Context) error {
    log.Printf("Scheduler started, interval: %v", s.interval)
    
    ticker := time.NewTicker(s.interval)
    defer ticker.Stop()
    
    s.processCycle(ctx)
    
    for {
        select {
        case <-ctx.Done():
            log.Println("Shutting down...")
            return s.redisQueue.Close()
        case <-ticker.C:
            s.processCycle(ctx)
        }
    }
}

func (s *Scheduler) processCycle(ctx context.Context) {
    start := time.Now()
    
    jobs, err := s.apiClient.GetDueJobs(ctx)
    if err != nil {
        log.Printf("Failed to fetch jobs: %v", err)
        return
    }
    
    if len(jobs) == 0 {
        log.Printf("No due jobs (took %v)", time.Since(start))
        return
    }
    
    log.Printf("Processing %d jobs", len(jobs))
    
    processed := 0
    for _, job := range jobs {
        if !job.IsActive {
            continue
        }
        
        if err := s.redisQueue.PushJob(ctx, job); err != nil {
            log.Printf("Failed to queue job %d: %v", job.ID, err)
        } else {
            processed++
        }
    }
    
    log.Printf("Processed %d/%d jobs in %v", processed, len(jobs), time.Since(start))
}