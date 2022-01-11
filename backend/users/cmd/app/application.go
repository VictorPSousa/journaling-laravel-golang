package app

import (
	"fmt"
	"users/cmd/config"
	"users/cmd/controller"
	"users/cmd/mapper"
	"users/cmd/repository"
	"users/cmd/service"
	"users/cmd/util"

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
	app.createUserFlow()

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

func (a *Application) createUserFlow() {
	userRepository := repository.NewUserRepository(a.db)

	userMapper := mapper.NewUserMapper()

	authService := common.NewAuthService()
	userService := service.NewUserService(userRepository, authService, userMapper)

	authMiddleware := middleware.NewAuthMiddleware(authService)

	userV1Controller := controller.NewUsersV1Controller(userService, authMiddleware)

	userV1Controller.Setup(a.engine)

	loginv1Controller := controller.NewLoginV1Controller(userService, authMiddleware)

	loginv1Controller.Setup(a.engine)
}
