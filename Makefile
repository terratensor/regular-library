init: docker-down \
	app-clear \
	docker-pull docker-build docker-up \
	app-init
up: docker-up
down: docker-down
restart: down up

app-clear:
	docker run --rm -v ${PWD}/app:/app -w /app alpine sh -c 'rm -rf app/var/cache/* var/log/* var/test/*'
	docker run --rm -v ${PWD}/app:/app -w /app alpine sh -c 'rm -rf app/runtime/cache/*'

app-init: app-permissions app-composer-install \
	app-console \
	app-migrations \

app-permissions:
	docker run --rm -v ${PWD}/app:/app -w /app alpine chmod 777 runtime web/assets data

app-composer-install:
	docker compose run --rm app composer install

app-console:
	docker compose run --rm app php init-actions --interactive=0
	docker compose run --rm app php yii initial/index --interactive=0

app-migrations:
	docker compose run --rm app php yii migrate --interactive=0	

docker-pull:
	docker compose pull

docker-build:
	DOCKER_BUILDKIT=1 COMPOSE_DOCKER_CLI_BUILD=1 docker compose build --build-arg BUILDKIT_INLINE_CACHE=1 --pull

push-dev-cache:
	docker compose push

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

build: build-frontend \

build-frontend:
	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
		--target builder \
		--cache-from ${REGISTRY}/library-app:cache-builder \
		--tag ${REGISTRY}/library-app:cache-builder \
		--file app/docker/production/Dockerfile app

	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
		--cache-from ${REGISTRY}/library-app:cache-builder \
		--cache-from ${REGISTRY}/library-app:cache \
		--tag ${REGISTRY}/library-app:cache \
		--tag ${REGISTRY}/library-app:${IMAGE_TAG} \
        --file app/docker/production/Dockerfile app

push:
	docker push ${REGISTRY}/library-app:${IMAGE_TAG}