.PHONY: up down build migrate fresh seed shell routes test

# Start all containers in background
up:
	cd backend && ./vendor/bin/sail up -d

# Stop all containers
down:
	cd backend && ./vendor/bin/sail down

# Rebuild Docker images (after Dockerfile changes)
build:
	cd backend && ./vendor/bin/sail build --no-cache

# Run database migrations
migrate:
	cd backend && ./vendor/bin/sail artisan migrate

# Fresh database (drop all tables + migrate + seed)
fresh:
	cd backend && ./vendor/bin/sail artisan migrate:fresh --seed

# Run database seeders
seed:
	cd backend && ./vendor/bin/sail artisan db:seed

# Open a bash shell inside the backend container
shell:
	cd backend && ./vendor/bin/sail shell

# List all API routes
routes:
	cd backend && ./vendor/bin/sail artisan route:list

# Run tests
test:
	cd backend && ./vendor/bin/sail artisan test
