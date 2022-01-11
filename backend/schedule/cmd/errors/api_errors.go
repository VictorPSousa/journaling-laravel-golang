package errors

import (
	"net/http"

	"github.com/jhonnycpp/lds-0221-common/cmd/errors"
)

var (
	BadRequest = errors.NewApiError(
		http.StatusBadRequest,
		"bad_request",
		"Bad request.",
	)
	CouldNotCreateSchedule = errors.NewApiError(
		http.StatusInternalServerError,
		"could_not_create_schedule",
		"Could not create schedule.",
	)
	CouldNotDeleteSchedule = errors.NewApiError(
		http.StatusInternalServerError,
		"could_not_delete_schedule",
		"Could not delete schedule.",
	)
	CouldNotUpdateSchedule = errors.NewApiError(
		http.StatusInternalServerError,
		"could_not_update_schedule",
		"Could not update schedule.",
	)
	CouldNotParseID = errors.NewApiError(
		http.StatusBadRequest,
		"could_not_parse_id",
		"ID must be a positive number.",
	)
	EmailNotFound = errors.NewApiError(
		http.StatusNotFound,
		"email_not_found",
		"Email not found.",
	)
	InvalidAuth = errors.NewApiError(
		http.StatusUnauthorized,
		"invalid_token",
		"Invalid token.",
	)
	InvalidTimeFormat = errors.NewApiError(
		http.StatusBadRequest,
		"invalid_time_format",
		"Invalid time format.",
	)
	InvalidTimePeriod = errors.NewApiError(
		http.StatusBadRequest,
		"invalid_time_period",
		"The event start must be before its end",
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
	ScheduleNotFound = errors.NewApiError(
		http.StatusNotFound,
		"schedule_not_found",
		"Schedule not found.",
	)
	ServiceUnavailable = errors.NewApiError(
		http.StatusServiceUnavailable,
		"service_unavailable",
		"Service unavailable.",
	)
)
