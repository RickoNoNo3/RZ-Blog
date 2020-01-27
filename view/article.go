package view

import (
	//"os"
	"os/exec"
	"github.com/labstack/echo"
	"strings"
)

// GetArticle makes a page of an article drawed by php.
// This function is used to make article page being static.
// It's good for SEO.
func GetArticle(c echo.Context) error {
	// get file loc from request URL
	// domain.host/view/path/to/articlefile
	fileloc := strings.TrimPrefix(c.Request().URL.Path, "/view/")

	// check if the fileloc have already contained some type suffix
	checkSuffix := func(suffixs []string) bool {
		for i, _ := range suffixs {
			if strings.HasSuffix(fileloc, suffixs[i]) {
				return true
			}
		}
		return false;
	}

	// checking for txt html php js css md
	if !checkSuffix([]string{".txt", ".html", ".php", ".js", ".css", ".md"}) {
		fileloc += ".md"
	}

	// call php
	cmd := exec.Command("php", "php-view/article.php" , fileloc)
	html, err := cmd.Output()
	if err != nil {
		return c.String(404, "")
	}
	return c.HTML(200, string(html))
}

