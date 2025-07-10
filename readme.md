
docker network create primenet

docker run -d \
  --name otel-lgtm \
  --network primenet \
  -p 3001:3000 \
  grafana/otel-lgtm

docker run -d \
  --name pgdb \
  --network primenet \
  -e POSTGRES_USER=user \
  -e POSTGRES_PASSWORD=password \
  -e POSTGRES_DB=testdb \
  -p 5432:5432 \
  postgres:9


docker cp init.sql pgdb:/init.sql
docker exec -u postgres pgdb psql -U user  -d testdb -f /init.sql

docker run -d --name httpbin --network primenet kennethreitz/httpbin

docker rm -f phpapi && docker build -t php56-api . \
&& \
docker run -d \
  --name phpapi \
  --network primenet \
  -p 8080:80 \
  php56-api \
&& \
docker run -d \
  --name beyla \
  --network primenet \
  -e BEYLA_OPEN_PORT=80 \
  -e BEYLA_TRACE_PRINTER=text \
  -e OTEL_EXPORTER_OTLP_PROTOCOL="http/protobuf" \
  -e OTEL_EXPORTER_OTLP_ENDPOINT=http://otel-lgtm:4318 \
  --pid="container:phpapi" \
  --privileged \
  grafana/beyla:latest


remove everything

docker rm -f otel-lgtm
docker rm -f pgdb
docker rm -f httpbin
docker rm -f phpapi
docker rm -f beyla