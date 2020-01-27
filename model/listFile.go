package model

import (
	"io/ioutil"
	"sort"
	"strings"

	"github.com/labstack/echo"
)

type ListInfo struct {
	Name  string `json:"name"`
	Time  string `json:"time"`
	IsDir bool   `json:"isDir"`
}

// List is used to list articles and dirs in the dir contaning in c.
// It returns a JSON string in {name, time, isDir} ordered by time (but dir first)
func GetList(c echo.Context) error {
	// read dir
	dir := "./resource/articles/" + strings.TrimPrefix(c.Request().URL.Path, "/list/")
	list, err := ioutil.ReadDir(dir)
	if err != nil {
		return c.String(404, "")
	}

	// sort with custom func
	sort.Slice(list, func(i, j int) bool {
		if list[i].IsDir() && !list[j].IsDir() {
			return true
		}
		if list[j].IsDir() && !list[i].IsDir() {
			return false
		}
		return list[i].ModTime().Unix() > list[j].ModTime().Unix()
	})

	// make file list (as slice)
	file := make([]ListInfo, len(list))
	for i, fi := range list {
		file[i] = ListInfo{strings.TrimSuffix(fi.Name(), ".md"), fi.ModTime().Format("2006/01/02"), fi.IsDir()}
	}
	return c.JSON(200, file)
}
