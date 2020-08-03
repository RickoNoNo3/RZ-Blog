package main

import (
	"context"
	"fmt"
	"go_playground/articleProcess/drawer"
	"go_playground/articleProcess/logger"
	"go_playground/articleProcess/sqlite"
	"go_playground/articleProcess/user"
	"io/ioutil"
	"os"
	"strconv"
	"time"

	"github.com/labstack/echo"
	"github.com/labstack/echo/middleware"
)

var flag = 1
var e = echo.New()

//JSON处理\uxxx 没地方放先放这
// outStr := string(out)
// outStr, err = strconv.Unquote(strings.Replace(strconv.Quote(outStr), `\\u`, `\u`, -1))
// outStr = strings.ReplaceAll(outStr, "\\n", "<br>")
// out = []byte(outStr)

func main() {
	defer sqlite.CloseDB()
	e.Use(middleware.CORS())
	e.Use(middleware.Gzip())
	e.Use(middleware.LoggerWithConfig(middleware.LoggerConfig{
		Format:           "${time_custom}|${remote_ip}|${method}|${path}|${status}\n",
		Output:           logger.New("./log.csv"),
		CustomTimeFormat: "2006-01-02 15:04:05.000",
	}))
	// View 部分
	// e.Any("/", webview.IndexH)
	// e.Any("/blog/:did", webview.BlogDirH)
	// e.Any("/blog/:did/:aid", webview.BlogArticleH)
	// e.Any("/about", webview.AboutH)
	// e.Any("/admin/:did", webview.AdminDirH)
	// e.Any("/admin/:did/:aid", webview.AdminArticleH)
	// Ajax 部分
	// e.POST("/api/:name", webapi.AjaxH)
	// 特殊功能
	e.Static("/drawer/*", "drawer/")
	e.Static("/mathjax/*", "drawer/web/mathjax/")
	e.Any("/preview", func(c echo.Context) error {
		title, htmlres := cmd_draw(1)
		return c.HTML(200, "<title>"+title+"</title>"+"<link rel='stylesheet' href='/drawer/web/mjx-chtml.css'>"+htmlres)
	})
	e.Any("/RickoNoNo3/close", func(c echo.Context) error {
		// user.IsAdmin(c.Cookie("userHash")) ||
		if user.IsConsole(c.RealIP()) {
			ctx, cancel := context.WithTimeout(context.Background(), 10*time.Second)
			defer cancel()
			go e.Shutdown(ctx)
		}
		return c.String(200, "")
	})
	e.Start(":13810")
	if len(os.Args) >= 2 {
		switch os.Args[1] {
		case "draw": // 读取os.Args[2]作为文章id, 进行数据库内渲染
			if len(os.Args) >= 3 {
				id, err := strconv.Atoi(os.Args[2])
				if err == nil {
					cmd_draw(id)
				}
			}
		case "drawCore": // 读取os.Args[2]作为输入文件, 缺省为Stdin, 渲染输出到Stdout
			inputFile := os.Stdin
			if len(os.Args) >= 3 {
				tmpFile, err := os.Open(os.Args[2])
				if err == nil {
					inputFile = tmpFile
				}
			}
			cmd_drawCore(inputFile, os.Stdout)
		case "new":
			// cmd_new()
		case "edit":
			// cmd_edit()
		case "move":
			// cmd_move()
		case "remove":
			// cmd_remove()
		case "read":
			// cmd_read()
		}
	} else {
		showHelp()
	}
	if flag != 0 {
		sqlite.CloseDB()
		fmt.Println(flag)
		os.Exit(flag)
	}
}

// 带数据库操作的渲染, 只给定文章Id
func cmd_draw(id int) (title, htmlres string) {
	md, err := sqlite.GetMarkDown(id)
	if err != nil {
		flag = 2
		return
	}
	title, htmlres = drawer.Drawer(md)
	err = sqlite.SetHtml(id, title, htmlres)
	if err == nil {
		flag = 0
	} else {
		flag = 3
	}
	return
}

// 直接文件流渲染
func cmd_drawCore(inputFile, outputFile *os.File) (title, htmlres string) {
	input, err := ioutil.ReadAll(inputFile)
	if err == nil {
		title, htmlres = drawer.Drawer(string(input))
		fmt.Fprintln(outputFile, htmlres)
		flag = 0
	}
	return
}

func showHelp() {
	fmt.Println("+-------------------------")
	fmt.Println("| NOTE: Type should be one of 0:dir, 1:article.")
	fmt.Println("+-------------------------")
	fmt.Println("| HELP: ")
	fmt.Println("|       ")
	fmt.Println("| draw <articleId>    Use database to draw article to html.")
	fmt.Println("|                     Use database to draw article to html.")
	fmt.Println("|       ")
	fmt.Println("| drawCore [filename] Use file(or stdin) as input to draw")
	fmt.Println("|                     article. Output to stdout.")
	fmt.Println("|                     Used by previewTool.")
	fmt.Println("|   + Stdin Format:     Just markdown text.")
	fmt.Println("|   + Stdout Format:    Just html text.")
	fmt.Println("|       ")
	fmt.Println("| new <type> [dirId]  Write a new article or dir to the dir")
	fmt.Println("|                     that dirId pointed.")
	fmt.Println("|                     Default dirId is 0(root).")
	fmt.Println("|   + Stdin Format:     If type=0, just markdown text.")
	fmt.Println("|                       If type=1, just name text in one line.")
	fmt.Println("|   + Stdout Format:    The new article/dir id in one line.")
	fmt.Println("|       ")
	fmt.Println("| edit <type> <id>    edit an article markdown or dir name")
	fmt.Println("|   + Stdin Format:     If type=0, just markdown text.")
	fmt.Println("|                       If type=1, just name text within one line.")
	fmt.Println("|       ")
	fmt.Println("| move [dirId]        Move to the dir that dirId pointed.")
	fmt.Println("|                     Default dirId is 0(root).")
	fmt.Println("|   + Stdin Format:     Each line means an article or dir:")
	fmt.Println("|                         <type> <id>")
	fmt.Println("|       ")
	fmt.Println("| remove              Remove from database.")
	fmt.Println("|   + Stdin Format:     Each line means an article or dir:")
	fmt.Println("|                         <type> <id>")
	fmt.Println("|       ")
	fmt.Println("| read <articleid>    Get the article or list the dir.")
	fmt.Println("|   + Stdin Format:     If type=0, just markdown text.")
	fmt.Println("|                       If type=1, just name text within one line.")
	fmt.Println("|   + Stdout Format:    Json(string): {")
	fmt.Println("|                         title      string,")
	fmt.Println("|                         html       string,")
	fmt.Println("|                         createdT   datetime,")
	fmt.Println("|                         modifiedT  datetime,")
	fmt.Println("|                         tags       []string,")
	fmt.Println("|                         contents:  []{")
	fmt.Println("|                           text       string,")
	fmt.Println("|                           id         string,")
	fmt.Println("|                           contents   []{...}")
	fmt.Println("|                         }")
	fmt.Println("|                       }")
	fmt.Println("|       ")
	fmt.Println("| list <dirId>        Get the file list of the dir.")
	fmt.Println("|   + Stdout Format:    Json(string): []{")
	fmt.Println("|                         type       int,")
	fmt.Println("|                         text       string,")
	fmt.Println("|                         createdT   datetime,")
	fmt.Println("|                         modifiedT  datetime,")
	fmt.Println("|                       }")
	fmt.Println("+-------------------------")
}
