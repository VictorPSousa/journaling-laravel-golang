package app

import (
	"fmt"
	"notes/cmd/config"
	"notes/cmd/controller"
	"notes/cmd/mapper"
	"notes/cmd/repository"
	"notes/cmd/service"
	"notes/cmd/util"

	"github.com/gin-gonic/gin"
	"github.com/jhonnycpp/lds-0221-common/cmd/middleware"
	common "github.com/jhonnycpp/lds-0221-common/cmd/service"
	"gorm.io/gorm"
)

type Application struct {
	engine      *gin.Engine
	environment *config.EnvironmentConfig
	db          *gorm.DB
}

func Create(environment *config.EnvironmentConfig) (app *Application, err error) {
	app = &Application{
		engine:      gin.Default(),
		environment: environment,
	}

	app.db, err = environment.NewDatabaseConnection()
	if err != nil {
		return
	}

	app.createNoteFlow()

	return
}

func (a *Application) Run(instancePort string) (err error) {
	port := util.CoalesceString(instancePort, a.environment.Port, config.DefaultPort)
	err = a.engine.Run(fmt.Sprintf(":%s", port))
	return
}

func (a *Application) createNoteFlow() {
	noteRepository := repository.NewNoteRepository(a.db)
	noteMapper := mapper.NewNoteMapper()

	authService := common.NewAuthService()
	noteService := service.NewNoteService(noteRepository, authService, noteMapper)

	authMiddleware := middleware.NewAuthMiddleware(authService)
	notesV1Controller := controller.NewNotesV1Controller(noteService, authMiddleware)

	notesV1Controller.Setup(a.engine)
}
