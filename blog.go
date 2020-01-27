/*
@author RickoNoNo3
The go backend of my personal blog

It should works with php file './php-view/article.php'
*/
package main

import (
	"github.com/labstack/echo"
	"github.com/labstack/echo/middleware"
	"github.com/RickoNoNo3/RZ-Blog/model"
	"github.com/RickoNoNo3/RZ-Blog/view"
)

func ConListFile(c echo.Context) error {
	return model.GetList(c)
}

func ConArticle(c echo.Context) error {
	return view.GetArticle(c)
}

func ConPage(c echo.Context) error {
	return view.GetPage(c)
}

func main() {
	e := echo.New()
	e.Use(interface{}(middleware.CORS()).(echo.MiddlewareFunc))
	e.GET("/*", ConPage)
	e.GET("/list/*", ConListFile)
	e.GET("/view/*", ConArticle)
	e.Logger.Fatal(e.Start(":8888"))
}
