# gicho-skeleton
Skeleton of a fully functioning, deployable, microservice

## Getting up and running
> docker-compose up -d

## Accessing the application via a browser
> http://localhost:8080/

## Accessing the application via the console
> docker-compose exec app php console ping

## Accessing the application via the listeners
> docker-compose exec app php attach --connection redis:first --listener process-data
> docker-compose exec app php console push-data
