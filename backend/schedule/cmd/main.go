package main

import (
	"fmt"
	"schedule/cmd/app"
	"schedule/cmd/config"
	"schedule/cmd/util"
)

func main() {
	port := util.GetVariable(portKey)
	scope := util.GetVariable(scopeKey)
	environment := config.GetEnvironmentConfig(scope)

	app, err := app.Create(environment)

	if err != nil {
		println(fmt.Errorf("Occurred an error starting server.", err))
		return
	}

	err = app.Run(port)

	if err != nil {
		println("Occurred error to run application.")
	}
}

const (
	portKey  = "PORT"
	scopeKey = "SCOPE"
)
