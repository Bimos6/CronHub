package queue

import (
    "context"
    "encoding/json"
    "fmt"
    "time"
    
    "github.com/redis/go-redis/v9"
    "cron-scheduler/internal/models"
    "cron-scheduler/internal/config"
)

type RedisQueue struct {
    client *redis.Client
    queue  string
}

func NewRedisQueue(cfg *config.Config) (*RedisQueue, error) {
    opts, err := redis.ParseURL(cfg.RedisURL)
    if err != nil {
        opts = &redis.Options{Addr: cfg.RedisURL}
    }
    
    client := redis.NewClient(opts)
    
    ctx, cancel := context.WithTimeout(context.Background(), 5*time.Second)
    defer cancel()
    
    if err := client.Ping(ctx).Err(); err != nil {
        return nil, fmt.Errorf("redis connect: %w", err)
    }
    
    return &RedisQueue{
        client: client,
        queue:  cfg.QueueName,
    }, nil
}

func (q *RedisQueue) PushJob(ctx context.Context, job models.Job) error {
    message := models.QueueMessage{
        JobID:     job.ID,
        URL:       job.URL,
        Method:    job.Method,
        Payload:   string(job.Payload),
        Headers:   string(job.Headers),
        Timestamp: time.Now(),
    }
    
    data, err := json.Marshal(message)
    if err != nil {
        return fmt.Errorf("marshal job: %w", err)
    }
    
    return q.client.LPush(ctx, q.queue, data).Err()
}

func (q *RedisQueue) Close() error {
    return q.client.Close()
}