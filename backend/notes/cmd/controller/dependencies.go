package controller

import (
	"notes/cmd/model/dto"

	"github.com/gin-gonic/gin"
)

type iNoteService interface {
	Create(note *dto.CreateNoteRequest) (err error)
	Update(note *dto.UpdateNoteRequest) (err error)
	Delete(note *dto.DeleteNoteRequest) (err error)
	GetNoteAll(user string) ([]dto.NoteResponse, error)
	GetNote(note *dto.NoteRequest) (*dto.NoteResponse, error)
}

type iAuthMiddleware interface {
	Auth() gin.HandlerFunc
	GetEmail(context *gin.Context) (email string, err error)
}
