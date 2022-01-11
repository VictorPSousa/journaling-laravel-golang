package repository

import (
	"schedule/cmd/model/entity"

	e "schedule/cmd/errors"

	"gorm.io/gorm"
)

type ScheduleRepository struct {
	db *gorm.DB
}

func NewScheduleRepository(db *gorm.DB) *ScheduleRepository {
	return &ScheduleRepository{
		db: db,
	}
}

func (r *ScheduleRepository) SearchScheduleRules(schedule *entity.Schedule) (responses []entity.Schedule, err error) {
	status := r.db.Where(
		"email = ? AND ends_at  >= ? AND starts_at < ?",
		schedule.Email,
		schedule.StartsAt,
		schedule.EndsAt,
	).Find(&responses)

	if status.RowsAffected > 0 {
		return responses, status.Error
	} else {
		return nil, status.Error
	}
}

func (r *ScheduleRepository) CreateScheduleRules(schedule *entity.Schedule) (err error) {
	status := r.db.Create(&schedule)

	if err != nil {
		err = e.CouldNotCreateSchedule
	}

	return status.Error
}

func (r *ScheduleRepository) GetScheduleRules(schedule *entity.Schedule) (response entity.Schedule, err error) {
	status := r.db.Where(
		"email = ? and id = ?",
		schedule.Email,
		schedule.ID,
	).First(&response)

	if err != nil || status.RowsAffected == 0 {
		err = e.ScheduleNotFound
	}

	return
}

func (r *ScheduleRepository) UpdateScheduleRules(schedule *entity.Schedule) (err error) {
	status := r.db.Save(&schedule)

	if status.Error != nil {
		err = e.CouldNotUpdateSchedule
	}

	return
}

func (r *ScheduleRepository) DeleteScheduleRules(schedule *entity.Schedule) (err error) {
	status := r.db.Delete(&schedule)

	if status.Error != nil {
		err = e.CouldNotDeleteSchedule
	}

	return
}
