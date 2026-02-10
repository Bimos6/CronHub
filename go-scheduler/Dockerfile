FROM golang:1.18-alpine AS builder

WORKDIR /app

COPY go.mod .
RUN go mod download

COPY . .

RUN cp .env.example .env;

RUN CGO_ENABLED=0 GOOS=linux go build -o scheduler ./cmd/scheduler

FROM scratch
WORKDIR /root/
COPY --from=builder /app/scheduler .
CMD ["./scheduler"]