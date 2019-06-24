.PHONY: style
style: ## executes php analizers
		./vendor/bin/phpstan analyse -l 7 -c phpstan.neon src

.PHONY: cs
cs: ## executes php analizers
		./vendor/bin/php-cs-fixer fix --allow-risky=yes


.PHONY: phpunit
phpunit: ## test
		./vendor/bin/phpunit

.PHONY: test
test: cs style phpunit

