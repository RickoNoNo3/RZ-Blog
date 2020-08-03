package drawer

import (
	"bytes"
	"context"
	"io"
	"net/http"
	"net/http/httptest"
	"os"
	"regexp"
	"strings"
	"text/template"
	"time"

	"github.com/chromedp/chromedp"
)

// Render 用Parse的结果(内容部分的未渲染html)填充给定的模板drawer.html.
// 生成完整页面放入临时服务器, 用chrome headless执行渲染并保存结果.
// 这里的渲染指的是打开网页时加载各类JS引擎(highlight/mathjax/viz).
func Render(htmlori string) (htmlres string) {
	htmlres = htmlori
	// 模板填充
	tmpl, err := template.ParseFiles("drawer/web/drawer.html")
	if err != nil {
		return
	}
	buf := new(bytes.Buffer)
	err = tmpl.Execute(buf, htmlori)
	if err != nil {
		return
	}
	htmlexec := buf.String()

	// 创建临时服务器
	ts := httptest.NewServer(http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		if r.URL.Path == "/" { // 模板页面
			io.Copy(w, bytes.NewBufferString(htmlexec))
		} else { // 依赖文件
			file, err := os.Open("drawer/web" + r.URL.Path)
			if err != nil {
				return
			}
			defer file.Close()
			io.Copy(w, file)
		}
	}))
	defer ts.Close()

	// chrome 渲染
	pctx, cancel := context.WithTimeout(context.Background(), 10*time.Second)
	defer cancel()
	ctx, cancel := chromedp.NewContext(pctx)
	defer cancel()
	err = chromedp.Run(ctx,
		chromedp.Navigate(ts.URL), // 导航到模板页面
		chromedp.WaitReady("body>done"),
		chromedp.InnerHTML("body", &htmlres),
	)
	if err != nil {
		return
	}
	// done标记删除, draw=not-need的内容删除.
	reg, _ := regexp.Compile(`<done></done>|<script[^>]*draw="not-need"[\S\s]+?</script>`)
	htmlres = reg.ReplaceAllString(htmlres, "")
	// 连续多行空行压缩
	reg, _ = regexp.Compile(`\n{2,}`)
	htmlres = reg.ReplaceAllString(htmlres, "\n")
	// Trim
	htmlres = strings.Trim(htmlres, "\n 　\t")
	return
}
