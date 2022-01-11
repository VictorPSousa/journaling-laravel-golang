package entity

import (
	"gorm.io/gorm"
)

type Note struct {
	gorm.Model
	Title       string
	Description string
	User        string `gorm:"primaryKey"`
}
