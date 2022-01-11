package repository

import (
	"notes/cmd/model/entity"

	"gorm.io/gorm"
)

type NoteRepository struct {
	db *gorm.DB
}

func NewNoteRepository(db *gorm.DB) *NoteRepository {
	return &NoteRepository{
		db: db,
	}
}

func (r *NoteRepository) Create(note *entity.Note) (err error) {
	err = r.db.Transaction(
		func(tx *gorm.DB) error {
			if err := tx.Create(note).Error; err != nil {
				return err
			}
			return nil
		})
	return
}

func (r *NoteRepository) Update(note *entity.Note) (err error) {
	err = r.db.Transaction(
		func(tx *gorm.DB) error {
			if err := tx.Updates(note).Error; err != nil {
				return err
			}
			return nil
		})
	return
}

func (r *NoteRepository) Delete(note *entity.Note) (err error) {
	err = r.db.Transaction(
		func(tx *gorm.DB) error {
			if err := tx.Delete(note).Error; err != nil {
				return err
			}
			return nil
		})
	return
}

func (r *NoteRepository) GetNoteAll(user string) (response []entity.Note, err error) {
	err = r.db.Where(
		&entity.Note{
			User: user,
		}).Find(&response).Error
	return
}

func (r *NoteRepository) GetNote(note *entity.Note) (response *entity.Note, err error) {
	query := r.db.Where(note, "id", "user").Find(&response)
	err = query.Error
	if query.RowsAffected == 0 {
		response = nil
	}

	return
}
