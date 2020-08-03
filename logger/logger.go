package logger

import (
	"bytes"
	"encoding/csv"
	"io"
	"os"
	"strings"
)

type logger struct {
	logFile *os.File
}

func New(filename string) (l *logger) {
	l = new(logger)
	if info, err := os.Stat(filename); err == nil {
		mt := info.ModTime()
		os.Rename(filename, filename+"."+mt.Format("060102_150405"))
	}
	var err error
	l.logFile, err = os.Open(filename)
	if err != nil {
		l.logFile, err = os.Create(filename)
		if err != nil {
			l.logFile = nil
		}
	}
	return
}

func (l *logger) Write(p []byte) (n int, err error) {
	n64, err := io.Copy(os.Stdout, bytes.NewBuffer(p))
	if l.logFile != nil {
		csvWriter := csv.NewWriter(l.logFile)
		if err = csvWriter.Write(strings.Split(strings.Trim(string(p), "\n 　\t"), "|")); err == nil {
			csvWriter.Flush()
		}
	}
	n = int(n64)
	return
}
