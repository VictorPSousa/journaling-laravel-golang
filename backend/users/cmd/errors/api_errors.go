package errors

import (
	"net/http"

	"github.com/jhonnycpp/lds-0221-common/cmd/errors"
)

var (
	DuplicatedUser = errors.NewApiError(
		http.StatusConflict,
		"duplicated_user",
		"Duplicated user.",
	)
	UserNotFound = errors.NewApiError(
		http.StatusNotFound,
		"user_not_found",
		"User not found.",
	)
	UserLoginFailure = errors.NewApiError(
		http.StatusNotFound,
		"failure_login",
		"User not found or invalid password.",
	)
	UserCreateBadRequest = errors.NewApiError(
		http.StatusBadRequest,
		"user_create_bad_request",
		"Bad request to creating user.",
	)
	UserUpdateBadRequest = errors.NewApiError(
		http.StatusBadRequest,
		"user_update_bad_request",
		"Bad request to updating user.",
	)
	EmailNotFound = errors.NewApiError(
		http.StatusNotFound,
		"email_not_found",
		"Email not found",
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
