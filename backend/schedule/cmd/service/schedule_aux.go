package service

import (
	e "schedule/cmd/errors"
	"schedule/cmd/model/dto"
	"schedule/cmd/model/entity"
	"strconv"
	"time"
)

func (d *ScheduleService) validateID(parameter string) (uintID uint, err error) {
	id, err := strconv.ParseUint(parameter, 10, 64)
	if err != nil || id <= 0 {
		err = e.CouldNotParseID
		return
	}

	uintID = uint(id)
	return
}

func (d *ScheduleService) updateScheduleAttributes(dbSchedule *entity.Schedule, schedule *dto.DailyEventUpdate) (err error) {
	if schedule.Title != "" {
		dbSchedule.Title = schedule.Title
	}
	if schedule.Description != "" {
		dbSchedule.Description = schedule.Description
	}
	if schedule.StartsAt != "" {
		dbSchedule.StartsAt, err = time.Parse(time.RFC3339, schedule.StartsAt)
		if err != nil {
			err = e.InvalidTimeFormat
			return
		}
	}
	if schedule.EndsAt != "" {
		dbSchedule.EndsAt, err = time.Parse(time.RFC3339, schedule.EndsAt)
		if err != nil {
			err = e.InvalidTimeFormat
			return
		}
	}
	if schedule.Sun != "" {
		dbSchedule.Sun = d.stob(schedule.Sun)
	}
	if schedule.Mon != "" {
		dbSchedule.Mon = d.stob(schedule.Mon)
	}
	if schedule.Tue != "" {
		dbSchedule.Tue = d.stob(schedule.Tue)
	}
	if schedule.Wed != "" {
		dbSchedule.Wed = d.stob(schedule.Wed)
	}
	if schedule.Thu != "" {
		dbSchedule.Thu = d.stob(schedule.Thu)
	}
	if schedule.Fri != "" {
		dbSchedule.Fri = d.stob(schedule.Fri)
	}
	if schedule.Sat != "" {
		dbSchedule.Sat = d.stob(schedule.Sat)
	}
	return
}

func (d *ScheduleService) validateTimePeriod(schedule *entity.Schedule) (err error) {
	if !schedule.StartsAt.Before(schedule.EndsAt) {
		err = e.InvalidTimePeriod
	}

	return err
}

func (d *ScheduleService) stob(stringValue string) bool {
	boolValue, err := strconv.ParseBool(stringValue)

	if err != nil {
		boolValue = true
	}

	return boolValue
}

func (d *ScheduleService) validDate(t1 time.Time, event *entity.Schedule) bool {
	// Zera a hora dos dias, para que a comparação seja feita corretamente
	StartsAt := time.Date(event.StartsAt.Year(), event.StartsAt.Month(), event.StartsAt.Day(), 0, 0, 0, 0, time.UTC)
	EndsAt := time.Date(event.EndsAt.Year(), event.EndsAt.Month(), event.EndsAt.Day(), 0, 0, 0, 0, time.UTC)

	return !t1.Before(StartsAt) && !t1.After(EndsAt)
}

func (s *ScheduleService) GetWeekday(event *entity.Schedule) (weekday []bool) {
	weekday = append(weekday,
		event.Sun,
		event.Mon,
		event.Tue,
		event.Wed,
		event.Thu,
		event.Fri,
		event.Sat,
	)

	return
}
