cd /root/blog/
go build -o blog blog.go
chmod +x blog
nohup ./blog 1>/dev/null 2>&1 &
