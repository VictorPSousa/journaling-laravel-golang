package errors

import (
	"net/http"

	"github.com/jhonnycpp/lds-0221-common/cmd/errors"
)

var (
	DuplicatedNote = errors.NewApiError(
		http.StatusConflict,
		"duplicated_note",
		"Duplicated note.",
	)
	NoteNotFound = errors.NewApiError(
		http.StatusNotFound,
		"note_not_found",
		"Note not found.",
	)
	NoteLoginFailure = errors.NewApiError(
		http.StatusNotFound,
		"failure_login",
		"Note not found or invalid password.",
	)
	NoteCreateBadRequest = errors.NewApiError(
		http.StatusBadRequest,
		"note_create_bad_request",
		"Bad request to creating note.",
	)
	NoteDBError = errors.NewApiError(
		http.StatusInternalServerError,
		"note_database_error",
		"Failure query in database.",
	)
	NoteBadRequest = errors.NewApiError(
		http.StatusBadRequest,
		"note_bad_request",
		"Bad request to note.",
	)
	NoteUpdateBadRequest = errors.NewApiError(
		http.StatusBadRequest,
		"note_update_bad_request",
		"Bad request to updating note.",
	)
	InvalidAuth = errors.NewApiError(
		http.StatusUnauthorized,
		"invalid_token",
		"Invalid token.",
	)
	UnauthorizedError = errors.NewApiError(
		http.StatusUnauthorized,
		"unauthorized",
		"Unauthorized access",
	)
	UnknownError = errors.NewApiError(
		http.StatusInternalServerError,
		"unknown_error",
		"Unknown application error",
	)
)
