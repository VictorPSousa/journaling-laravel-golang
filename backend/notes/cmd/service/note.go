package service

import (
	"notes/cmd/errors"
	"notes/cmd/model/dto"
)

type NoteService struct {
	repository  iNoteRepository
	authService iAuthService
	mapper      iNoteMapper
}

func NewNoteService(repository iNoteRepository, authService iAuthService, mapper iNoteMapper) *NoteService {
	return &NoteService{
		repository:  repository,
		authService: authService,
		mapper:      mapper,
	}
}

func (s *NoteService) Create(note *dto.CreateNoteRequest) (err error) {
	entity := s.mapper.CreateNoteToNoteEntity(note)
	return s.repository.Create(entity)
}

func (s *NoteService) Update(note *dto.UpdateNoteRequest) (err error) {
	entity := s.mapper.UpdateNoteToNoteEntity(note)
	currentNote, err := s.repository.GetNote(entity)
	if err != nil {
		return
	}

	if currentNote != nil {
		currentNote.Title = entity.Title
		currentNote.Description = entity.Description

		return s.repository.Update(currentNote)
	}

	return errors.NoteNotFound
}

func (s *NoteService) Delete(note *dto.DeleteNoteRequest) (err error) {
	entity := s.mapper.DeleteNoteToNoteEntity(note)
	currentNote, err := s.repository.GetNote(entity)
	if err != nil {
		return errors.NoteDBError
	}

	if currentNote != nil {
		return s.repository.Delete(currentNote)
	}

	return errors.NoteNotFound
}

func (s *NoteService) GetNoteAll(user string) (response []dto.NoteResponse, err error) {
	currentNote, err := s.repository.GetNoteAll(user)

	if err != nil {
		return
	}

	response = s.mapper.ToNoteAllResponse(currentNote)

	return
}

func (s *NoteService) GetNote(note *dto.NoteRequest) (response *dto.NoteResponse, err error) {
	entity := s.mapper.ToNoteEntity(note)
	currentNote, err := s.repository.GetNote(entity)

	if err != nil {
		return nil, errors.NoteDBError
	}

	if currentNote != nil {
		response = s.mapper.ToNoteResponse(currentNote)
		return response, nil
	}

	return nil, errors.NoteNotFound
}
