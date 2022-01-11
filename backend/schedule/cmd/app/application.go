package app

import (
	"fmt"
	"schedule/cmd/config"
	"schedule/cmd/controller"
	"schedule/cmd/repository"
	"schedule/cmd/service"
	"schedule/cmd/util"

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

	app.createHealthControllers()
	app.createScheduleFlow()

	return
}

func (a *Application) Run(instancePort string) (err error) {
	port := util.CoalesceString(instancePort, a.environment.Port, config.DefaultPort)
	err = a.engine.Run(fmt.Sprintf(":%s", port))
	return
}

func (a *Application) createHealthControllers() {
	healthCheckController := controller.NewV1HealthCheckController()

	healthCheckController.Setup(a.engine)
}

func (a *Application) createScheduleFlow() {
	scheduleRepository := repository.NewScheduleRepository(a.db)

	authService := common.NewAuthService()
	scheduleService := service.NewScheduleService(scheduleRepository)

	authMiddleware := middleware.NewAuthMiddleware(authService)

	scheduleV1Controller := controller.NewScheduleV1Controller(scheduleService, authMiddleware)

	scheduleV1Controller.Setup(a.engine)
}
