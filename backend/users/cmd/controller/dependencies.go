package controller

import (
	"users/cmd/model/dto"

	"github.com/gin-gonic/gin"
)

type iUserService interface {
	Create(user *dto.CreateUserRequest) (err error)
	Update(user *dto.UserRequest) (err error)
	Delete(user *dto.UserRequest) (err error)
	GetByEmail(email string) (*dto.UserResponse, error)
	CreateRecovery(recovery *dto.CreateRecoveryRequest) (response, err error)
	FinishRecovery(recovery *dto.FinishRecoveryRequest) (err error)
	Login(user *dto.UserLoginRequest) (session *dto.UserSession, err error)
}

type iAuthMiddleware interface {
	Auth() gin.HandlerFunc
	GetEmail(context *gin.Context) (email string, err error)
}
