package service

import (
	"users/cmd/model/dto"
	"users/cmd/model/entity"
)

type iUserRepository interface {
	Create(user *entity.User) error
	Update(user *entity.User)
	Delete(user *entity.User) error
	GetUser(user *entity.User) (*entity.User, error)
}
type iUserMapper interface {
	ToUserEntity(request *dto.UserRequest) *entity.User
	ToUserResponse(entity *entity.User) *dto.UserResponse
	ToUserSession(token string) *dto.UserSession
	CreateToUserEntity(request *dto.CreateUserRequest) *entity.User
}

type iAuthService interface {
	GenerateToken(email string) (string, error)
	ValidateToken(token string) (email string, err error)
}
