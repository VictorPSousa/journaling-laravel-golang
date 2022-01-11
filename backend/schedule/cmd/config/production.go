package config

import (
	"time"

	"gorm.io/driver/sqlite"
	"gorm.io/gorm"
)

func getProduction() *EnvironmentConfig {
	return &EnvironmentConfig{
		Port:     DefaultPort,
		LogLevel: "DEBUG",
		TwitchApi: ApiConfig{
			Url:     "",
			Name:    "twitch-api",
			Timeout: 3 * time.Second,
		},
		NewDatabaseConnection: func() (db *gorm.DB, err error) {
			db, err = gorm.Open(sqlite.Open("test.db"), &gorm.Config{})
			if err != nil {
				return nil, err
			}
			// db.AutoMigrate(&en)

			return
		},
	}
}
