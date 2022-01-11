package dto

type UpdateNoteRequest struct {
	Id          uint   `json:"id"`
	Title       string `json:"title"`
	Description string `json:"description"`
	User        string `json:"-"`
}

type CreateNoteRequest struct {
	Id          uint   `json:"id"`
	Title       string `json:"title"`
	Description string `json:"description"`
	User        string `json:"-"`
}

type DeleteNoteRequest struct {
	Id   uint   `json:"id"`
	User string `json:"-"`
}

type NoteRequest struct {
	Id   uint   `json:"id"`
	User string `json:"-"`
}

type NoteResponse struct {
	Id          uint   `json:"id"`
	Title       string `json:"title"`
	Description string `json:"description"`
}
