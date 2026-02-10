package queue

import (
    "context"
    "encoding/json"
    "fmt"
    "time"
    
    "github.com/redis/go-redis/v9"
    "go-worker/internal/models"
)

type RedisQueue struct {
    client *redis.Client
    queue  string
}

func NewRedisQueue(redisURL, queueName string) (*RedisQueue, error) {
    opts, err := redis.ParseURL(redisURL)
    if err != nil {
        opts = &redis.Options{Addr: redisURL}
    }
    
    client := redis.NewClient(opts)
    
    ctx, cancel := context.WithTimeout(context.Background(), 5*time.Second)
    defer cancel()
    
    if err := client.Ping(ctx).Err(); err != nil {
        return nil, fmt.Errorf("redis connect: %w", err)
    }
    
    return &RedisQueue{
        client: client,
        queue:  queueName,
    }, nil
}

func (q *RedisQueue) Pop(ctx context.Context) (*models.JobMessage, error) {
    result, err := q.client.BRPop(ctx, 0, q.queue).Result()
    if err != nil {
        return nil, err
    }
    
    var msg models.JobMessage
    if err := json.Unmarshal([]byte(result[1]), &msg); err != nil {
        return nil, err
    }
    
    return &msg, nil
}

func (q *RedisQueue) QueueName() string {
    return q.queue
}