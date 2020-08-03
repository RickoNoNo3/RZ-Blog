package user

import (
	"crypto/md5"
	"fmt"
	"net/http"
	"strings"
	"time"
)

var UserHash string

func init() {
	MakeUserHash()
}

func MakeUserHash() {
	UserHash = fmt.Sprintf("%x", md5.Sum([]byte(time.Now().Format("060102150304"))))
}

func IsAdmin(cookie *http.Cookie, err error) bool {
	if err != nil {
		return false
	}
	return cookie.Value == UserHash
}

func IsConsole(ip string) bool {
	return strings.HasPrefix(ip, "127.0.0")
}
