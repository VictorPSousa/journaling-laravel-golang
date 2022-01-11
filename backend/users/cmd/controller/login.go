package controller

import (
	"fmt"
	"net/http"
	"users/cmd/model/dto"

	e "users/cmd/errors"

	"github.com/gin-gonic/gin"
	"github.com/gin-gonic/gin/binding"
	"github.com/jhonnycpp/lds-0221-common/cmd/errors"
)

type LoginV1Controller struct {
	service        iUserService
	authMiddleware iAuthMiddleware
}

func NewLoginV1Controller(service iUserService, authMiddleware iAuthMiddleware) *LoginV1Controller {
	return &LoginV1Controller{
		service:        service,
		authMiddleware: authMiddleware,
	}
}

func (controller *LoginV1Controller) Setup(router *gin.Engine) {
	routes := router.Group("/login")
	{
		routes.POST("", controller.login)
	}
}

func (controller *LoginV1Controller) login(context *gin.Context) {
	var body dto.UserLoginRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[LoginV1Controller][login] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.UserNotFound)
		return
	}

	if session, err := controller.service.Login(&body); err == nil {
		context.JSON(http.StatusOK, session)
		return
	}

	errors.SendErrorRespose(context, e.UserNotFound)
}
