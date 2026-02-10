package models

import (
    "encoding/json"
    "time"
)

type JobMessage struct {
    JobID     int             `json:"job_id"`
    URL       string          `json:"url"`
    Method    string          `json:"method"`
    Payload   json.RawMessage `json:"payload"`
    Headers   json.RawMessage `json:"headers"`
    Timestamp time.Time       `json:"timestamp"`
}