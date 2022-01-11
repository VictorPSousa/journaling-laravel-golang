package dto

type CreateUserRequest struct {
	Email           string `json:"email"`
	Password        string `json:"password"`
	ConfirmPassword string `json:"confirm_password"`
	Name            string `json:"name"`
}

type UserRequest struct {
	Email           string `json:"-"`
	Password        string `json:"password,omitempty"`
	ConfirmPassword string `json:"confirm_password,omitempty"`
	Name            string `json:"name,omitempty"`
}

type UserResponse struct {
	Email string `json:"email"`
	Name  string `json:"name,omitempty"`
}

type UserLoginRequest struct {
	Email    string `json:"email"`
	Password string `json:"password"`
}

type UserSession struct {
	Token string `json:"token"`
}

type CreateRecoveryRequest struct {
	Email string `json:"email"`
}

type FinishRecoveryRequest struct {
	Email           string `json:"email"`
	Password        string `json:"password"`
	ConfirmPassword string `json:"confirm_password"`
}
