package service

import (
	"notes/cmd/model/dto"
	"notes/cmd/model/entity"
)

type iNoteRepository interface {
	Create(note *entity.Note) error
	Update(note *entity.Note) error
	Delete(note *entity.Note) error
	GetNoteAll(user string) ([]entity.Note, error)
	GetNote(note *entity.Note) (*entity.Note, error)
}

type iNoteMapper interface {
	CreateNoteToNoteEntity(request *dto.CreateNoteRequest) *entity.Note
	UpdateNoteToNoteEntity(request *dto.UpdateNoteRequest) *entity.Note
	DeleteNoteToNoteEntity(request *dto.DeleteNoteRequest) *entity.Note
	ToNoteEntity(request *dto.NoteRequest) *entity.Note
	ToNoteAllResponse(entity []entity.Note) []dto.NoteResponse
	ToNoteResponse(entity *entity.Note) *dto.NoteResponse
}

type iAuthService interface {
	GenerateToken(email string) (string, error)
	ValidateToken(token string) (email string, err error)
}
