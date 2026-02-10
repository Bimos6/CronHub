package models

import (
    "encoding/json"
    "time"
)

type Job struct {
    ID             int             `json:"id"`
    UserID         int             `json:"user_id"`
    Name           string          `json:"name"`
    URL            string          `json:"url"`
    Method         string          `json:"method"`
    CronExpression string          `json:"cron_expression"`
    Payload        json.RawMessage `json:"payload"`
    Headers        json.RawMessage `json:"headers"`
    IsActive       bool            `json:"is_active"`
    LastRunAt      *time.Time      `json:"last_run_at"`
    NextRunAt      *time.Time      `json:"next_run_at"`
}

type DueJobsResponse struct {
    Jobs []Job `json:"jobs"`
}

type QueueMessage struct {
    JobID     int       `json:"job_id"`
    URL       string    `json:"url"`
    Method    string    `json:"method"`
    Payload   string    `json:"payload"`
    Headers   string    `json:"headers"`
    Timestamp time.Time `json:"timestamp"`
}