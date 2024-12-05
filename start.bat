set REGISTRY=ghcr.io/terratensor
set IMAGE_TAG=main
docker compose down
docker compose pull
docker compose up -d
docker exec -it library-app php init-actions --interactive=0
docker exec -it library-app php yii initial/index --interactive=0
docker exec -it library-app php yii migrate --interactive=0	