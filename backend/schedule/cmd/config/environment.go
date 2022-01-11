package config

import (
	"time"

	"gorm.io/gorm"
)

type DatabaseConnection func() (*gorm.DB, error)

type EnvironmentConfig struct {
	Port                  string
	LogLevel              string
	TwitchApi             ApiConfig
	NewDatabaseConnection DatabaseConnection
}

type ApiConfig struct {
	Url          string
	Name         string
	MaxIdleConns int
	Timeout      time.Duration
}

func GetEnvironmentConfig(scope string) *EnvironmentConfig {
	switch scope {
	case production:
		return getProduction()
	case staging:
		return getStaging()
	default:
		return getLocal()
	}
}

const (
	DefaultPort = "8081"
	staging     = "staging"
	local       = "local"
	production  = "production"
)
