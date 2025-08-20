# LARAVEL
docker compose up
php artisan migrate
php artisan queue:work redis
php artisan schedule:run
serve

# Environment
SCOUT_DRIVER=meilisearch  
MEILISEARCH_HOST=http://127.0.0.1:7700  
MEILISEARCH_KEY=SAMPLE_MASTER_KEY  
SCOUT_QUEUE=true  

QUEUE_CONNECTION=redis  
CACHE_STORE=redis  
REDIS_CLIENT=predis  
REDIS_HOST=127.0.0.1  
REDIS_PASSWORD=null  
REDIS_PORT=6379  
REDIS_DB=0   
REDIS_CACHE_DB=1  

# Postman Collection
backend/postman  
