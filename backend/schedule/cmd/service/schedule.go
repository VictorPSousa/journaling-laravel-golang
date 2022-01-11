package service

import (
	"schedule/cmd/model/dto"
	"schedule/cmd/model/entity"
	"schedule/cmd/repository"
	"time"

	"gorm.io/gorm"
)

type ScheduleService struct {
	repository *repository.ScheduleRepository
}

func NewScheduleService(repository *repository.ScheduleRepository) *ScheduleService {
	return &ScheduleService{
		repository: repository,
	}
}

func (d *ScheduleService) Search(email string, parameter *dto.DailyEventSearch) (*dto.DailyEvents, error) {
	agenda := &dto.DailyEvents{}
	s, err := d.repository.SearchScheduleRules(&entity.Schedule{
		Email:    email,
		StartsAt: parameter.StartAt.AddDate(0, 0, -1),
		EndsAt:   parameter.EndAt,
	})
	if err != nil {
		return nil, err
	}

	t1 := parameter.StartAt
	t2 := parameter.EndAt

	for t1.Before(t2) {
		for _, event := range s {
			if d.validDate(t1, &event) {
				if d.GetWeekday(&event)[int(t1.Weekday())] {
					agenda.Nodes = append(agenda.Nodes, dto.DailyEvent{
						Id:          event.ID,
						Title:       event.Title,
						Description: event.Description,
						StartsAt:    time.Date(t1.Year(), t1.Month(), t1.Day(), event.StartsAt.Hour(), event.StartsAt.Minute(), event.StartsAt.Second(), 0, event.StartsAt.Location()),
						EndsAt:      time.Date(t1.Year(), t1.Month(), t1.Day(), event.EndsAt.Hour(), event.EndsAt.Minute(), event.EndsAt.Second(), 0, event.EndsAt.Location()),
					})
				}
			}
		}
		t1 = t1.AddDate(0, 0, 1)
	}
	return agenda, nil
}

func (d *ScheduleService) AltSearch(email string, parameter *dto.DailyEventSearch) (*dto.DailyEvents, error) {
	agenda := &dto.DailyEvents{}
	s, err := d.repository.SearchScheduleRules(&entity.Schedule{
		Email:    email,
		StartsAt: parameter.StartAt,
		EndsAt:   parameter.EndAt,
	})
	if err != nil {
		return nil, err
	}

	for _, event := range s {
		agenda.Nodes = append(agenda.Nodes, dto.DailyEvent{
			Id:          event.ID,
			Title:       event.Title,
			Description: event.Description,
			StartsAt:    event.StartsAt,
			EndsAt:      event.EndsAt,
		})
	}
	return agenda, nil
}

func (d *ScheduleService) Create(email string, parameter *dto.DailyEventCreate) (err error) {
	schedule := &entity.Schedule{
		Email:       email,
		Title:       parameter.Title,
		Description: parameter.Description,
		StartsAt:    parameter.StartsAt,
		EndsAt:      parameter.EndsAt,
		Sun:         d.stob(parameter.Sun),
		Mon:         d.stob(parameter.Mon),
		Tue:         d.stob(parameter.Tue),
		Wed:         d.stob(parameter.Wed),
		Thu:         d.stob(parameter.Thu),
		Fri:         d.stob(parameter.Fri),
		Sat:         d.stob(parameter.Sat),
	}

	// err = d.validateTimePeriod(schedule)
	// if err != nil {
	// 	return
	// }

	err = d.repository.CreateScheduleRules(schedule)

	return
}

func (d *ScheduleService) Update(email string, parameter *dto.DailyEventUpdate) (err error) {
	id, err := d.validateID(parameter.ScheduleId)
	if err != nil {
		return
	}

	dbSchedule, err := d.repository.GetScheduleRules(&entity.Schedule{
		Model: gorm.Model{
			ID: id,
		},
		Email: email,
	})
	if err != nil {
		return
	}

	err = d.updateScheduleAttributes(&dbSchedule, parameter)
	if err != nil {
		return
	}

	// err = d.validateTimePeriod(&dbSchedule)
	// if err != nil {
	// 	return
	// }

	err = d.repository.UpdateScheduleRules(&dbSchedule)
	if err != nil {
		return
	}

	return
}

func (d *ScheduleService) Delete(email string, parameter *dto.DailyEventDelete) (err error) {
	id, err := d.validateID(parameter.ScheduleId)
	if err != nil {
		return
	}

	dbSchedule, err := d.repository.GetScheduleRules(&entity.Schedule{
		Model: gorm.Model{
			ID: id,
		},
		Email: email,
	})
	if err != nil {
		return
	}

	err = d.repository.DeleteScheduleRules(&dbSchedule)
	if err != nil {
		return
	}

	return
}
