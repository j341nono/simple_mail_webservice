
## compose を使った起動
```bash
docker compose up --detach --build
```

## コンテナの個別の起動
### Mail コンテナの起動
```bash
docker container run \
--name app \
--rm \
--detach \
--publish 8000:8000 \
--mount type=bind,source="$(pwd)"/src,destination=/my-work \
--network work-network \
work-app:0.1.0 \
/usr/local/bin/php --server 0.0.0.0:8000 --docroot /my-work
```

### DB コンテナの起動
```bash
docker container run \
--name db \
--rm \
--detach \
--env MYSQL_ROOT_PASSWORD=secret \
--env MYSQL_PASSWORD=pass1234 \
--env MYSQL_DATABASE=sample \
--env TZ=Asia/Tokyo \
--publish 3306:3306 \
--mount type=bind,source="$(pwd)"/docker/db/init,dst=/docker-entrypoint-initdb.d \
--network work-network \
mysql:8.2.0
```

### Mail コンテナの起動
```bash
docker container run \
--name mail \
--rm \
--detach \
--env TZ=Asia/Tokyo \
--env MP_DATA_FILE=/data/mailpit.db \
--publish 8025:8025 \
--mount type=volume,source=work-mail-volume,destination=/data \
--network work-network \
axllent/mailpit:v1.10.1
```
