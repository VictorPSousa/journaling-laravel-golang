package controller

import (
	"fmt"
	"net/http"
	"schedule/cmd/model/dto"
	"schedule/cmd/service"

	e "schedule/cmd/errors"

	"github.com/gin-gonic/gin"
	"github.com/gin-gonic/gin/binding"
	"github.com/jhonnycpp/lds-0221-common/cmd/errors"
)

type ScheduleV1Controller struct {
	service *service.ScheduleService
	auth    iAuthMiddleware
}

func NewScheduleV1Controller(service *service.ScheduleService, auth iAuthMiddleware) *ScheduleV1Controller {
	return &ScheduleV1Controller{
		service: service,
		auth:    auth,
	}
}

func (controller *ScheduleV1Controller) Setup(router *gin.Engine) {
	safeRoutes := router.Group("/schedules").Use(controller.auth.Auth())
	{
		safeRoutes.POST("", controller.createSchedules)
		safeRoutes.PUT("", controller.updateSchedules)
		safeRoutes.DELETE("", controller.deleteSchedules)

		safeRoutes.POST("/search", controller.searchSchedules)

		safeRoutes.POST("/search/alt", controller.altSearchSchedules)
	}
}

func (controller *ScheduleV1Controller) searchSchedules(context *gin.Context) {
	var body dto.DailyEventSearch
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[ScheduleV1Controller][schedules] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.ScheduleNotFound)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	schedule, err := controller.service.Search(email, &body)
	if err != nil {
		errors.SendErrorRespose(context, e.ScheduleNotFound)
		return
	}

	context.JSON(http.StatusOK, schedule)
}

func (controller *ScheduleV1Controller) altSearchSchedules(context *gin.Context) {
	var body dto.DailyEventSearch
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[ScheduleV1Controller][schedules] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.ScheduleNotFound)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	if schedule, err := controller.service.AltSearch(email, &body); err == nil {
		context.JSON(http.StatusOK, schedule)
		return
	}

	errors.SendErrorRespose(context, e.ScheduleNotFound)
}

func (controller *ScheduleV1Controller) createSchedules(context *gin.Context) {
	var body dto.DailyEventCreate
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[ScheduleV1Controller][schedules] Error parsing request: %+v Error: %+v\n", raw, err)

		errors.SendErrorRespose(context, e.BadRequest)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	if err := controller.service.Create(email, &body); err != nil {
		errors.SendErrorRespose(context, err)
		return
	}

	context.Status(http.StatusCreated)
}

func (controller *ScheduleV1Controller) updateSchedules(context *gin.Context) {
	var body dto.DailyEventUpdate

	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[ScheduleV1Controller][schedules] Error parsing request: %+v Error: %+v\n", raw, err)

		errors.SendErrorRespose(context, e.BadRequest)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	if err := controller.service.Update(email, &body); err != nil {
		errors.SendErrorRespose(context, err)
		return
	}

	context.Status(http.StatusNoContent)
}

func (controller *ScheduleV1Controller) deleteSchedules(context *gin.Context) {
	var body dto.DailyEventDelete

	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[ScheduleV1Controller][schedules] Error parsing request: %+v Error: %+v\n", raw, err)

		errors.SendErrorRespose(context, e.BadRequest)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.EmailNotFound)
		return
	}

	if err := controller.service.Delete(email, &body); err != nil {
		errors.SendErrorRespose(context, err)
		return
	}

	context.Status(http.StatusNoContent)
}
