build:
	docker build . -t enum_image -f Dockerfile

composer-update: build
	docker run -w /app -v $(shell pwd):/app enum_image composer update
	sudo chmod 777 -R vendor

composer-install: build
	docker run -w /app -v $(shell pwd):/app enum_image composer install
	sudo chmod 777 -R vendor

phpstan:
	docker run -w /app -v $(shell pwd):/app enum_image php vendor/bin/phpstan analyse src -l max

phpunit:
	docker run -w /app -v $(shell pwd):/app enum_image php vendor/bin/phpunit --coverage-html temp/coverage

test: phpstan phpunit

