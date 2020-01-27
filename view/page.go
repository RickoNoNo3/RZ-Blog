package view

import (
	// "os/exec"
	"strings"

	"github.com/labstack/echo"
)

// Has been banned
func GetPage(c echo.Context) error {
	loc := strings.TrimPrefix(c.Request().URL.Path, "/")
	if loc == "" {
		loc = "index.php"
	}
	return c.File("./resource/" + loc)
	/*if strings.Contains(loc, ".php") {
		cmd := exec.Command("/usr/bin/php", loc)
		html, err = cmd.Output()
		if err != nil {
			return c.String(404, "")
		}
		return c.HTML(200, string(html))
	} else {
		return c.File(loc)
	}*/
}

