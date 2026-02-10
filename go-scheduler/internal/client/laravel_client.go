package api

import (
    "context"
    "encoding/json"
    "fmt"
    "net/http"
    "time"
    
    "cron-scheduler/internal/models"
    "cron-scheduler/internal/config"
)

type LaravelClient struct {
    baseURL string
    apiKey  string
    client  *http.Client
}

func NewLaravelClient(cfg *config.Config) *LaravelClient {
    return &LaravelClient{
        baseURL: cfg.LaravelURL,
        apiKey:  cfg.ServiceKey,
        client: &http.Client{
            Timeout: 10 * time.Second,
        },
    }
}

func (c *LaravelClient) GetDueJobs(ctx context.Context) ([]models.Job, error) {
    req, err := http.NewRequestWithContext(ctx, "GET", c.baseURL+"/api/v1/jobs/due", nil)
    if err != nil {
        return nil, fmt.Errorf("create request: %w", err)
    }
    
    req.Header.Set("X-Service-Key", c.apiKey)
    
    resp, err := c.client.Do(req)
    if err != nil {
        return nil, fmt.Errorf("http request: %w", err)
    }
    defer resp.Body.Close()
    
    if resp.StatusCode != http.StatusOK {
        return nil, fmt.Errorf("status %d", resp.StatusCode)
    }
    
    var response models.DueJobsResponse
    if err := json.NewDecoder(resp.Body).Decode(&response); err != nil {
        return nil, fmt.Errorf("decode json: %w", err)
    }
    
    return response.Jobs, nil
}