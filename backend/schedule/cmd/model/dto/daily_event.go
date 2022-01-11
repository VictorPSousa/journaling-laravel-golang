package dto

import (
	"time"

	"gorm.io/gorm"
)

type DailyEvents struct {
	Nodes []DailyEvent `json:"events"`
}

type DailyEventSearch struct {
	StartAt time.Time `json:"starts_at"`
	EndAt   time.Time `json:"ends_at"`
}

type DailyEventCreate struct {
	gorm.Model
	Title       string    `json:"title"`
	Description string    `json:"description"`
	StartsAt    time.Time `json:"starts_at"`
	EndsAt      time.Time `json:"ends_at"`
	Sun         string    `json:"sun"`
	Mon         string    `json:"mon"`
	Tue         string    `json:"tue"`
	Wed         string    `json:"wed"`
	Thu         string    `json:"thu"`
	Fri         string    `json:"fri"`
	Sat         string    `json:"sat"`
}

type DailyEventUpdate struct {
	ScheduleId  string `json:"id"`
	Title       string `json:"title"`
	Description string `json:"description"`
	StartsAt    string `json:"starts_at"`
	EndsAt      string `json:"ends_at"`
	Sun         string `json:"sun"`
	Mon         string `json:"mon"`
	Tue         string `json:"tue"`
	Wed         string `json:"wed"`
	Thu         string `json:"thu"`
	Fri         string `json:"fri"`
	Sat         string `json:"sat"`
}

type DailyEventDelete struct {
	ScheduleId string `json:"id"`
}

type DailyEvent struct {
	Id          uint      `json:"id"`
	Title       string    `json:"title"`
	Description string    `json:"description"`
	StartsAt    time.Time `json:"starts_at"`
	EndsAt      time.Time `json:"ends_at"`
}
