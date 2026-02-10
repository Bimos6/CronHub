package processor

import (
    "context"
    "encoding/json"
    "fmt"
    "io"
    "net/http"
    "strings"
    "time"
    
    "go-worker/internal/models"
    "go.uber.org/zap"
)

type HTTPClient interface {
    Do(req *http.Request) (*http.Response, error)
}

type Processor struct {
    client HTTPClient
    logger *zap.Logger
}

func NewProcessor(logger *zap.Logger) *Processor {
    return &Processor{
        client: &http.Client{
            Timeout: 30 * time.Second,
        },
        logger: logger,
    }
}

func (p *Processor) Process(ctx context.Context, job *models.JobMessage) error {
    p.logger.Info("Processing job",
        zap.Int("job_id", job.JobID),
        zap.String("url", job.URL),
        zap.String("method", job.Method),
    )
    
    payloadStr := string(job.Payload)
    
    var body io.Reader
    if payloadStr != "" && payloadStr != "{}" {
        body = strings.NewReader(payloadStr)
    }
    
    req, err := http.NewRequestWithContext(ctx, job.Method, job.URL, body)
    if err != nil {
        return fmt.Errorf("create request: %w", err)
    }
    
    headersStr := string(job.Headers)
    if headersStr != "" && headersStr != "{}" {
        var headers map[string]string
        if err := json.Unmarshal(job.Headers, &headers); err == nil {
            for key, value := range headers {
                req.Header.Set(key, value)
            }
        }
    }
    
    resp, err := p.client.Do(req)
    if err != nil {
        return fmt.Errorf("http request: %w", err)
    }
    defer resp.Body.Close()
    
    bodyBytes, _ := io.ReadAll(resp.Body)
    
    p.logger.Info("Job completed",
        zap.Int("job_id", job.JobID),
        zap.Int("status", resp.StatusCode),
        zap.String("response", string(bodyBytes)[:min(100, len(bodyBytes))]),
    )
    
    if resp.StatusCode >= 400 {
        return fmt.Errorf("bad status: %d", resp.StatusCode)
    }
    
    return nil
}

func min(a, b int) int {
    if a < b {
        return a
    }
    return b
}