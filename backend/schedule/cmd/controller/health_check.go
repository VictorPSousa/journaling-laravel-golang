package controller

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

type HealthCheckController struct {
}

func NewV1HealthCheckController() *HealthCheckController {
	return &HealthCheckController{}
}

func (controller *HealthCheckController) Setup(router *gin.Engine) {
	routes := router.Group("/")
	{
		routes.GET("", controller.status)
	}
}

func (controller *HealthCheckController) status(c *gin.Context) {
	c.JSON(http.StatusOK, map[string]interface{}{
		"status":   http.StatusOK,
		"data":     "All ok.",
		"dhasjdha": "asdasd",
	})
}
