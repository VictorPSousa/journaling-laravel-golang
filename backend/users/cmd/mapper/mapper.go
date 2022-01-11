package mapper

import (
	"users/cmd/model/dto"
	"users/cmd/model/entity"
)

type UserMapper struct {
}

func NewUserMapper() *UserMapper {
	return &UserMapper{}
}

func (m *UserMapper) CreateToUserEntity(request *dto.CreateUserRequest) *entity.User {
	return &entity.User{
		Name:     request.Name,
		Email:    request.Email,
		Password: request.Password,
	}
}

func (m *UserMapper) ToUserEntity(request *dto.UserRequest) *entity.User {
	return &entity.User{
		Name:     request.Name,
		Email:    request.Email,
		Password: request.Password,
	}
}

func (m *UserMapper) ToUserResponse(entity *entity.User) *dto.UserResponse {
	return &dto.UserResponse{
		Name:  entity.Name,
		Email: entity.Email,
	}
}

func (m *UserMapper) ToUserSession(token string) *dto.UserSession {
	return &dto.UserSession{
		Token: token,
	}
}
