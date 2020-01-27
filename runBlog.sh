cd /home/rick/Programs/blog/
go build -o blog.run blog.go
chmod +x blog
nohup ./blog 1>/dev/null 2>&1 &
