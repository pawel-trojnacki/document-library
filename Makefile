docker-build:
	docker compose --env-file .env.local build
docker-up:
	docker compose --env-file .env.local up -d
docker-stop:
	docker compose --env-file .env.local stop
docker-down:
	docker compose --env-file .env.local down
docker-restart:
	docker compose --env-file .env.local restart