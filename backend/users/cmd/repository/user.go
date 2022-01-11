package repository

import (
	"users/cmd/model/entity"

	"gorm.io/gorm"
)

type UserRepository struct {
	db *gorm.DB
}

func NewUserRepository(db *gorm.DB) *UserRepository {
	return &UserRepository{
		db: db,
	}
}

func (r *UserRepository) Create(user *entity.User) (err error) {
	err = r.db.Transaction(
		func(tx *gorm.DB) error {
			if err := tx.Create(user).Error; err != nil {
				return err
			}
			return nil
		})
	return
}

func (r *UserRepository) Update(user *entity.User) {

	r.db.Save(&user)
}

func (r *UserRepository) Delete(user *entity.User) (err error) {
	err = r.db.Transaction(
		func(tx *gorm.DB) error {
			if err := tx.Delete(user).Error; err != nil {
				return err
			}
			return nil
		})
	return
}

func (r *UserRepository) GetUser(user *entity.User) (response *entity.User, err error) {
	query := r.db.Where(
		&entity.User{
			Email: user.Email,
		}).Find(&response)

	if query.RowsAffected > 0 {
		return response, query.Error
	} else {
		return nil, query.Error
	}
}
