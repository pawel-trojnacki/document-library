# Document Library

## Overview

Document Library is a web application designed for storing and managing documents.
It allows users to upload documents and search for them by title, description, content extracted from the document etc.
The project follows basic DDD concepts and implements the CQRS patterns.

**This is a learning project and is not production-ready.**

## Tech Stack

- PHP & Symfony
- React (Vite)
- MySQL
- Elasticsearch
- Nginx

## Project Structure

- `api/` - Contains the Symfony backend application.
- `frontend/` - Contains the React frontend application.
- `.env` files - Environment configuration files.
- `docker/` - Contains Docker-related configurations, including Nginx and PHP.
- `docker-compose.yml` - Defines the services for Docker Compose.
- `Makefile` - Includes commands to manage Docker containers.

## What Could Be Improved

Since this is a learning project, several improvements could be made to enhance its architecture and security, e.g.:

- Some events should be handled asynchronously in Symfony instead of being processed synchronously to improve performance.
- Authentication should be done using cookies rather than storing authentication tokens in local storage for better security.
- The frontend is intentionally kept as simple as possible, but it could be improved with better architecture, UI/UX, and error handling.

## Prerequisites

Ensure you have the following installed on your system:

- Docker & Docker Compose

## Setup and Installation

### 1. Environment Configuration

Copy the provided `.env` files to `.env.local` in the respective locations:

```
cp .env .env.local
cp api/.env api/.env.local
cp frontend/.env frontend/.env.local
```

Update the values in `.env.local` files according to your setup.

### 2. Build and Start the Application

Use the `Makefile` to manage Docker containers:

```
make docker-build   # Build the application
make docker-up      # Start the application
```

The services will be available at:

- **Frontend**: `http://localhost:3000`
- **Backend**: `http://localhost:5000`
- **Elasticsearch**: `http://localhost:9200`

To stop the running containers:

```
make docker-stop
```

## Development

All commands should be executed inside the respective Docker containers.

### Backend (Symfony)

Access the PHP container:

```
docker exec -it dl-php bash
```

Then run:

```
composer install
php bin/console cache:clear
```

### Frontend (React + Vite)

Access the frontend container:

```
docker exec -it dl-frontend sh
```

Then run:

```
npm install
npm run dev
```

The frontend should now be available at `http://localhost:3000`.

## Elasticsearch Configuration

Elasticsearch is secured by default. The environment variable `ELASTIC_PASSWORD` in the `.env.local` file should be set before running the application.

To interact with Elasticsearch, use:

```
curl -u elastic:$ELASTIC_PASSWORD http://localhost:9200
```
