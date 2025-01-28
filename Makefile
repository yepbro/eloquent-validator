up:
	docker-compose up
down:
	docker-compose down
bash:
	docker exec -t -i eloquent-validator-php /bin/bash
tinker:
	vendor/bin/testbench tinker