##@ [Application: QA]

.PHONY: test
test: ## Run the test suite
	$(EXECUTE_IN_APPLICATION_CONTAINER) vendor/bin/phpunit tests