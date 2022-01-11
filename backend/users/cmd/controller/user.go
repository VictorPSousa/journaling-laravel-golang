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

type UsersV1Controller struct {
	service iUserService
	auth    iAuthMiddleware
}

func NewUsersV1Controller(service iUserService, auth iAuthMiddleware) *UsersV1Controller {
	return &UsersV1Controller{
		service: service,
		auth:    auth,
	}
}

func (c *UsersV1Controller) Setup(router *gin.Engine) {
	routes := router.Group("/user")
	{
		routes.POST("", c.create)
		routes.POST("/recovery", c.startRecovery)
		routes.POST("/recoverybyemailandpassword", c.recoveryByEmailAndpassword)
		routes.PUT("/recovery", c.finishRecovery)
	}

	safeRoutes := router.Group("/user").Use(c.auth.Auth())
	{
		safeRoutes.PUT("", c.update)
		safeRoutes.DELETE("", c.delete)
		safeRoutes.GET("", c.get)
	}
}

func (controller *UsersV1Controller) create(context *gin.Context) {
	var body dto.CreateUserRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[UsersV1Controller][create] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.UserCreateBadRequest)
		return
	}

	fmt.Printf("Received this body: %+v\n", body)

	if err := controller.service.Create(&body); err != nil {
		fmt.Printf("Failure create user: %+v error: %+v\n", body, err)
		errors.SendErrorRespose(context, err)
		return
	}

	fmt.Printf("Successful creating user: %+v\n", body)
	context.Status(http.StatusOK)
}

func (controller *UsersV1Controller) update(context *gin.Context) {
	var body dto.UserRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[UsersV1Controller][update] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.UserUpdateBadRequest)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	body.Email = email

	fmt.Printf("Received this body: %+v\n", body)
	if err := controller.service.Update(&body); err != nil {
		fmt.Printf("Failure update user: %+v error: %+v\n", body, err)
		errors.SendErrorRespose(context, err)
		return
	}

	fmt.Printf("Successful updating user: %+v\n", body)
	context.Status(http.StatusOK)
}

func (controller *UsersV1Controller) get(context *gin.Context) {
	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	user, err := controller.service.GetByEmail(email)
	if err == nil {
		context.JSON(http.StatusOK, user)
		return
	}

	errors.SendErrorRespose(context, e.UserNotFound)
}

func (controller *UsersV1Controller) delete(context *gin.Context) {
	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	body := dto.UserRequest{
		Email: email,
	}

	if err := controller.service.Delete(&body); err != nil {
		fmt.Printf("Failure delete user: %+v error: %+v\n", body, err)
		errors.SendErrorRespose(context, err)
		return
	}

	fmt.Printf("Successful delete user: %+v\n", body)
	context.Status(http.StatusOK)
}

func (controller *UsersV1Controller) startRecovery(context *gin.Context) {
	var body dto.CreateRecoveryRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[UsersV1Controller][startRecovery] Error parsing request: %+v Error: %+v\n", raw, err)
		context.Status(http.StatusBadRequest)
		return
	}

	fmt.Printf("Received this body: %+v\n", body)
	result, err := controller.service.CreateRecovery(&body)
	if err != nil {
		fmt.Printf("Failure start recovery user: %+v error: %+v\n", body, err)
		context.Status(http.StatusInternalServerError)
		return
	}

	fmt.Printf("Successful starting recovery user: %+v\n", result)
	context.Status(http.StatusOK)
}

func (controller *UsersV1Controller) getRecovery(context *gin.Context) {
	context.Status(http.StatusOK)
}

func (controller *UsersV1Controller) recoveryByEmailAndpassword(context *gin.Context) {
	var body dto.FinishRecoveryRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[UsersV1Controller][startRecovery] Error parsing request: %+v Error: %+v\n", raw, err)
		context.Status(http.StatusBadRequest)
		return
	}

	fmt.Printf("Received this body: %+v\n", body)
	userRequest := &dto.UserRequest{Email: body.Email, Password: body.Password, ConfirmPassword: body.ConfirmPassword}
	result := controller.service.Update(userRequest)

	fmt.Printf("Successful starting recovery user: %+v\n", result)
	context.Status(http.StatusOK)
}

func (controller *UsersV1Controller) finishRecovery(context *gin.Context) {
	var body dto.FinishRecoveryRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[UsersV1Controller][finishRecovery] Error parsing request: %+v Error: %+v\n", raw, err)
		context.Status(http.StatusBadRequest)
		return
	}

	fmt.Printf("Received this body: %+v\n", body)
	if err := controller.service.FinishRecovery(&body); err != nil {
		fmt.Printf("Failure finish recovery user: %+v error: %+v\n", body, err)
		context.Status(http.StatusInternalServerError)
		return
	}

	fmt.Printf("Successful finish recovery user: %+v\n", body)
	context.Status(http.StatusOK)
}
