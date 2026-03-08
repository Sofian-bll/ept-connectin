.PHONY: install up down build migrate fresh seed shell tinker routes test dev frontend

# First-time project setup (after git clone)
install:
	@command -v php >/dev/null 2>&1 || { echo "Error: PHP is not installed."; exit 1; }
	@command -v composer >/dev/null 2>&1 || { echo "Error: Composer is not installed."; exit 1; }
	@command -v docker >/dev/null 2>&1 || { echo "Error: Docker is not installed. Install OrbStack (https://orbstack.dev) or Docker Desktop."; exit 1; }
	@echo "Setting up ConnectIN..."
	cp backend/.env.example backend/.env
	cd backend && composer install
	cd frontend && npm install
	cd backend && ./vendor/bin/sail up -d
	cd backend && ./vendor/bin/sail artisan key:generate
	cd backend && ./vendor/bin/sail artisan migrate
	@echo "Done! Backend: http://localhost | Frontend dev: make dev"

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

# Open Laravel Tinker (interactive PHP/Laravel console)
tinker:
	cd backend && ./vendor/bin/sail artisan tinker

# List all API routes
routes:
	cd backend && ./vendor/bin/sail artisan route:list

# Run tests
test:
	cd backend && ./vendor/bin/sail artisan test

# Frontend dev server (hot reload)
dev:
	cd frontend && npm run dev

# Build + run frontend container (production)
frontend:
	cd backend && docker compose up -d --build frontend
