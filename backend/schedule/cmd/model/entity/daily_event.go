package entity

import (
	"time"

	"gorm.io/gorm"
)

type Schedule struct {
	gorm.Model
	Email       string
	Title       string
	Description string
	StartsAt    time.Time
	EndsAt      time.Time
	Sun         bool
	Mon         bool
	Tue         bool
	Wed         bool
	Thu         bool
	Fri         bool
	Sat         bool
}
