package config

import (
	"fmt"
	"schedule/cmd/model/entity"
	"time"

	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

func getStaging() *EnvironmentConfig {
	return &EnvironmentConfig{
		Port:     DefaultPort,
		LogLevel: "DEBUG",
		TwitchApi: ApiConfig{
			Url:     "",
			Name:    "twitch-api",
			Timeout: 3 * time.Second,
		},
		NewDatabaseConnection: func() (db *gorm.DB, err error) {
			const (
				dbUser = "root"
				dbPass = "cATJm7HdBpxYll0hNnKO"
				dbName = "orgen"
				dbHost = "127.0.0.1"
				dbPort = "3306"
			)
			dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?parseTime=true&loc=Local", dbUser, dbPass, dbHost, dbPort, dbName)
			db, err = gorm.Open(mysql.Open(dsn), &gorm.Config{})
			if err != nil {
				return nil, err
			}

			err = db.AutoMigrate(&entity.Schedule{})

			return
		},
	}
}
