
docker network create phpnet

docker run -d \
  --name pgdb \
  --network phpnet \
  -e POSTGRES_USER=user \
  -e POSTGRES_PASSWORD=password \
  -e POSTGRES_DB=testdb \
  -p 5432:5432 \
  postgres:9


docker cp init.sql pgdb:/init.sql
docker exec -u postgres pgdb psql -U user  -d testdb -f /init.sql


docker build -t php56-api . && \
docker run -it --rm \
  --name phpapi \
  --network phpnet \
  -p 8080:80 \
  php56-api


docker run --rm \
  -e BEYLA_OPEN_PORT=80 \
  -e BEYLA_TRACE_PRINTER=text \
  -e OTEL_EXPORTER_OTLP_PROTOCOL="http/protobuf"
  -e OTEL_EXPORTER_OTLP_ENDPOINT=http://localhost:4318
  --pid="container:phpapi" \
  --privileged \
  grafana/beyla:latest