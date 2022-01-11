package mapper

import (
	"notes/cmd/model/dto"
	"notes/cmd/model/entity"

	"gorm.io/gorm"
)

type NoteMapper struct {
}

func NewNoteMapper() *NoteMapper {
	return &NoteMapper{}
}

func (m *NoteMapper) CreateNoteToNoteEntity(request *dto.CreateNoteRequest) *entity.Note {
	return &entity.Note{
		Model:       gorm.Model{ID: request.Id},
		Title:       request.Title,
		Description: request.Description,
		User:        request.User,
	}
}

func (m *NoteMapper) UpdateNoteToNoteEntity(request *dto.UpdateNoteRequest) *entity.Note {
	return &entity.Note{
		Model:       gorm.Model{ID: request.Id},
		Title:       request.Title,
		Description: request.Description,
		User:        request.User,
	}
}

func (m *NoteMapper) DeleteNoteToNoteEntity(request *dto.DeleteNoteRequest) *entity.Note {
	return &entity.Note{
		Model: gorm.Model{ID: request.Id},
		User:  request.User,
	}
}

func (m *NoteMapper) ToNoteEntity(request *dto.NoteRequest) *entity.Note {
	return &entity.Note{
		Model: gorm.Model{ID: request.Id},
		User:  request.User,
	}
}

func (m *NoteMapper) ToNoteAllResponse(entity []entity.Note) (ret []dto.NoteResponse) {
	for _, item := range entity {
		ret = append(ret, dto.NoteResponse{
			Id:          item.Model.ID,
			Title:       item.Title,
			Description: item.Description,
		})
	}
	return
}

func (m *NoteMapper) ToNoteResponse(entity *entity.Note) *dto.NoteResponse {
	return &dto.NoteResponse{
		Id:          entity.Model.ID,
		Title:       entity.Title,
		Description: entity.Description,
	}
}
