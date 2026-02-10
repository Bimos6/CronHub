package worker

import (
    "context"
    "sync"
    "time"
    
    "go-worker/internal/queue"
    "go-worker/internal/processor"
    "go.uber.org/zap"
)

type Worker struct {
    queue      *queue.RedisQueue
    processor  *processor.Processor
    numWorkers int
    wg         sync.WaitGroup
    stopChan   chan struct{}
    logger     *zap.Logger
}

func NewWorker(q *queue.RedisQueue, p *processor.Processor, numWorkers int, logger *zap.Logger) *Worker {
    return &Worker{
        queue:      q,
        processor:  p,
        numWorkers: numWorkers,
        stopChan:   make(chan struct{}),
        logger:     logger,
    }
}

func (w *Worker) Start(ctx context.Context) {
    w.logger.Info("Starting worker",
        zap.Int("workers", w.numWorkers),
        zap.String("queue", w.queue.QueueName()),
    )
    
    for i := 0; i < w.numWorkers; i++ {
        w.wg.Add(1)
        go w.workerLoop(ctx, i)
    }
}

func (w *Worker) workerLoop(ctx context.Context, id int) {
    defer w.wg.Done()
    
    w.logger.Debug("Worker started", zap.Int("id", id))
    
    for {
        select {
        case <-w.stopChan:
            w.logger.Debug("Worker stopping", zap.Int("id", id))
            return
        case <-ctx.Done():
            w.logger.Debug("Context cancelled", zap.Int("id", id))
            return
        default:
            w.processJob(ctx, id)
        }
    }
}

func (w *Worker) processJob(ctx context.Context, workerID int) {
    job, err := w.queue.Pop(ctx)
    if err != nil {
        w.logger.Error("Failed to pop job",
            zap.Int("worker_id", workerID),
            zap.Error(err),
        )
        time.Sleep(1 * time.Second)
        return
    }
    
    if err := w.processor.Process(ctx, job); err != nil {
        w.logger.Error("Failed to process job",
            zap.Int("worker_id", workerID),
            zap.Int("job_id", job.JobID),
            zap.Error(err),
        )
    } else {
        w.logger.Info("Job processed successfully",
            zap.Int("worker_id", workerID),
            zap.Int("job_id", job.JobID),
        )
    }
}

func (w *Worker) Stop() {
    close(w.stopChan)
    w.wg.Wait()
    w.logger.Info("Worker stopped")
}