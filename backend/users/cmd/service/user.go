package service

import (
	"bytes"
	"crypto/tls"
	"fmt"
	"html/template"
	"log"
	"net/mail"
	"net/smtp"
	"users/cmd/errors"
	"users/cmd/model/dto"
	"users/cmd/model/entity"
)

type UserService struct {
	repository  iUserRepository
	authService iAuthService
	mapper      iUserMapper
}

func NewUserService(repository iUserRepository, authService iAuthService, mapper iUserMapper) *UserService {
	return &UserService{
		repository:  repository,
		mapper:      mapper,
		authService: authService,
	}
}

func (s *UserService) Create(user *dto.CreateUserRequest) (err error) {
	entity := s.mapper.CreateToUserEntity(user)
	currentUser, err := s.repository.GetUser(entity)

	if err != nil {
		return
	}

	if currentUser != nil {
		return errors.DuplicatedUser
	}

	return s.repository.Create(entity)
}

func (s *UserService) Update(user *dto.UserRequest) (err error) {
	entity := s.mapper.ToUserEntity(user)
	currentUser, err := s.repository.GetUser(entity)

	if err != nil {
		return
	}

	if currentUser == nil {
		return errors.UserNotFound
	}

	currentUser.Email = entity.Email
	if entity.Name != "" {
		currentUser.Name = entity.Name
	}
	currentUser.Password = entity.Password

	s.repository.Update(currentUser)
	return
}

func (s *UserService) Delete(user *dto.UserRequest) (err error) {
	entity := s.mapper.ToUserEntity(user)
	currentUser, err := s.repository.GetUser(entity)

	if err != nil {
		return
	}

	if currentUser == nil {
		return errors.UserNotFound
	}

	return s.repository.Delete(currentUser)
}

func (s *UserService) GetByEmail(email string) (response *dto.UserResponse, err error) {
	currentUser, err := s.repository.GetUser(&entity.User{Email: email})

	if err != nil {
		return
	}

	if currentUser == nil {
		return nil, errors.UserNotFound
	}

	response = s.mapper.ToUserResponse(currentUser)

	return
}

func (s *UserService) Login(user *dto.UserLoginRequest) (userSession *dto.UserSession, err error) {
	loginUser := &entity.User{Email: user.Email}
	currentUser, err := s.repository.GetUser(loginUser)

	if err != nil {
		return
	}

	if currentUser == nil || currentUser.Password != user.Password {
		return nil, errors.UserLoginFailure
	}

	token, err := s.authService.GenerateToken(user.Email)

	if err != nil {
		return nil, errors.UserLoginFailure
	}

	return s.mapper.ToUserSession(token), nil
}

func (s *UserService) CreateRecovery(recovery *dto.CreateRecoveryRequest) (response, err error) {

	result, err := s.GetByEmail(recovery.Email)

	if err != nil {
		return err, response
	}

	if result == nil {
		return response, nil
	}

	sendEmail(result)

	//gerar uma senha aleatoria e enviar por e-mail e dps solicitar a alteração da senha
	//gerar um link com prazo de expiração e enviar para o email e solicitar a alteração da senha
	return response, err
}

func (s *UserService) FinishRecovery(recovery *dto.FinishRecoveryRequest) (err error) {
	return nil
}

type Dest struct {
	Name string
}

func checkErr(err error) {
	if err != nil {
		log.Panic(err)
	}
}

func sendEmail(user *dto.UserResponse) {
	from := mail.Address{"Orgen", "email@email.com"}
	to := mail.Address{user.Name, user.Email}
	subject := "Recuperação de conta"
	dest := Dest{Name: to.Address}

	headers := make(map[string]string)
	headers["From"] = from.String()
	headers["To"] = to.String()
	headers["Subject"] = subject
	headers["Content-Type"] = `text/html; charset="UTF-8"`

	message := ""
	for k, v := range headers {
		message += fmt.Sprintf("%s: %s\r\n", k, v)
	}

	t, err := template.ParseFiles("template.html")
	checkErr(err)

	buf := new(bytes.Buffer)
	err = t.Execute(buf, dest)
	checkErr(err)

	message += buf.String()

	servername := "smtp.gmail.com:465"
	host := "smtp.gmail.com"

	auth := smtp.PlainAuth("", "email@email.com", "pswd", host)

	tlsConfig := &tls.Config{
		InsecureSkipVerify: true,
		ServerName:         host,
	}

	conn, err := tls.Dial("tcp", servername, tlsConfig)
	checkErr(err)

	client, err := smtp.NewClient(conn, host)
	checkErr(err)

	err = client.Auth(auth)
	checkErr(err)

	err = client.Mail(from.Address)
	checkErr(err)

	err = client.Rcpt(to.Address)
	checkErr(err)

	w, err := client.Data()
	checkErr(err)

	_, err = w.Write([]byte(message))
	checkErr(err)

	err = w.Close()
	checkErr(err)

	client.Quit()
}
