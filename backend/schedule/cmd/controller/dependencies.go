package controller

import (
	"github.com/gin-gonic/gin"
)

type iAuthMiddleware interface {
	Auth() gin.HandlerFunc
	GetEmail(context *gin.Context) (email string, err error)
}
