package config

import (
	"fmt"
	"time"
	"users/cmd/model/entity"

	"gorm.io/driver/mysql"
	"gorm.io/gorm"
	"gorm.io/gorm/logger"
)

func getLocal() *EnvironmentConfig {
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
				dbPass = ""
				dbName = "orgen"
				dbHost = "127.0.0.1"
				dbPort = "3306"
			)
			dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?parseTime=true&loc=Local", dbUser, dbPass, dbHost, dbPort, dbName)
			db, err = gorm.Open(mysql.Open(dsn), &gorm.Config{
				Logger: logger.Default.LogMode(logger.Info),
			})
			if err != nil {
				return nil, err
			}

			err = db.AutoMigrate(&entity.User{})

			return
		},
	}
}
