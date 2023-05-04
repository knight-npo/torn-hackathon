build-and-push-app:
	docker build -t ${CONTAINER_REGISTRY}:tornhk-app-${IMAGE_TAG} -f build/Dockerfile .
	docker push ${CONTAINER_REGISTRY}:tornhk-app-${IMAGE_TAG}

build-and-push-migrate:
	docker build -t ${CONTAINER_REGISTRY}:tornhk-migrate-${IMAGE_TAG} -f build/migrate/Dockerfile .
	docker push ${CONTAINER_REGISTRY}:tornhk-migrate-${IMAGE_TAG}
