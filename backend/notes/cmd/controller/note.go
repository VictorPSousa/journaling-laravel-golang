package controller

import (
	"fmt"
	"net/http"
	"notes/cmd/constant"
	e "notes/cmd/errors"
	"notes/cmd/model/dto"
	"strconv"

	"github.com/gin-gonic/gin"
	"github.com/gin-gonic/gin/binding"
	"github.com/jhonnycpp/lds-0221-common/cmd/errors"
)

type NotesV1Controller struct {
	service iNoteService
	auth    iAuthMiddleware
}

func NewNotesV1Controller(service iNoteService, auth iAuthMiddleware) *NotesV1Controller {
	return &NotesV1Controller{
		service: service,
		auth:    auth,
	}
}

func (c *NotesV1Controller) Setup(router *gin.Engine) {

	safeRoutes := router.Group("/note").Use(c.auth.Auth())
	{
		safeRoutes.POST("", c.create)
		safeRoutes.PUT("", c.update)
		safeRoutes.DELETE("", c.delete)
		safeRoutes.GET("", c.getAll)
	}
}

func (controller *NotesV1Controller) create(context *gin.Context) {
	var body dto.CreateNoteRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[NotesV1Controller][create] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.NoteBadRequest)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.UnauthorizedError)
		return
	}

	body.User = email

	fmt.Printf("Received this body: %+v\n", body)
	if err := controller.service.Create(&body); err != nil {
		fmt.Printf("Failure create note: %+v error: %+v\n", body, err)
		errors.SendErrorRespose(context, err)
		return
	}

	fmt.Printf("Successful creating note: %+v\n", body)
	context.Status(http.StatusOK)
}

func (controller *NotesV1Controller) update(context *gin.Context) {
	var body dto.UpdateNoteRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[NotesV1Controller][update] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.NoteBadRequest)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.UnauthorizedError)
		return
	}

	body.User = email

	fmt.Printf("Received this body: %+v\n", body)
	if err := controller.service.Update(&body); err != nil {
		fmt.Printf("Failure update note: %+v error: %+v\n", body, err)
		errors.SendErrorRespose(context, err)
		return
	}

	fmt.Printf("Successful updating note: %+v\n", body)
	context.Status(http.StatusOK)
}

func (controller *NotesV1Controller) getAll(context *gin.Context) {
	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.UnauthorizedError)
		return
	}

	if paramId, ok := context.GetQuery(constant.IdParam); ok {
		id, err := strconv.ParseUint(paramId, 10, 64)
		if err != nil {
			errors.SendErrorRespose(context, e.NoteBadRequest)
		}

		note, err := controller.service.GetNote(&dto.NoteRequest{
			Id:   uint(id),
			User: email,
		})
		if err != nil {
			errors.SendErrorRespose(context, err)
			return
		}

		if note != nil {
			context.JSON(http.StatusOK, note)
			return
		}

		errors.SendErrorRespose(context, e.NoteNotFound)
		return
	}

	note, err := controller.service.GetNoteAll(email)
	if err != nil {
		errors.SendErrorRespose(context, e.NoteNotFound)
		return
	}

	context.JSON(http.StatusOK, note)
}

func (controller *NotesV1Controller) delete(context *gin.Context) {
	var body dto.DeleteNoteRequest
	if err := context.ShouldBindBodyWith(&body, binding.JSON); err != nil {
		var raw string
		if cb, ok := context.Get(gin.BodyBytesKey); ok {
			raw = string(cb.([]byte))
		}

		fmt.Printf("[NotesV1Controller][delete] Error parsing request: %+v Error: %+v\n", raw, err)
		errors.SendErrorRespose(context, e.NoteBadRequest)
		return
	}

	email, err := controller.auth.GetEmail(context)
	if err != nil {
		errors.SendErrorRespose(context, e.UnauthorizedError)
		return
	}

	body.User = email

	fmt.Printf("Received this body: %+v\n", body)
	if err := controller.service.Delete(&body); err != nil {
		fmt.Printf("Failure delete note: %+v error: %+v\n", body, err)
		errors.SendErrorRespose(context, err)
		return
	}

	fmt.Printf("Successful delete note: %+v\n", body)
	context.Status(http.StatusOK)
}
