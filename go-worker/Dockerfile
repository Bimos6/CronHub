FROM golang:1.18-alpine AS builder

WORKDIR /build

COPY go.mod go.sum ./

RUN go mod download

COPY . .

RUN cp .env.example .env;

RUN CGO_ENABLED=0 GOOS=linux go build -o app ./cmd/worker

FROM alpine:latest
WORKDIR /root/
COPY --from=builder /build/app .
CMD ["./app"]
