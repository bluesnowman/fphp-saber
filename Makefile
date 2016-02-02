##
# Copyright 2014-2016 Blue Snowman
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
##

########################################################################
# This Makefile is for working with PHPIUnit.
########################################################################

########################################################################
# Definitions
########################################################################

DOCKER_APP = saber-app
DOCKER_GIT = bluesnowman/fphp-saber
DOCKER_PORT = 5000

BOOTSTRAP_FILE = ./tests/Bootstrap.php
BOOTSTRAP_SWITCH = --bootstrap $(BOOTSTRAP_FILE)

COMPOSER_DIR = vendor
COMPOSER_PHAR = composer.phar
COMPOSER_URL = http://getcomposer.org/installer

PHPUNIT_DIR = ./
PHPUNIT_EXE = phpunit
PHPUNIT_PHAR = phpunit-5.1.4.phar
PHPUNIT_URL = https://phar.phpunit.de/$(PHPUNIT_PHAR)

UNIT_TESTS = ./tests

########################################################################
# Rules (for Testing)
########################################################################

# make unit-test
# make unit-test GROUP=the_group_name
unit-test:
ifndef GROUP
	$(PHPUNIT_DIR)$(PHPUNIT_EXE) $(BOOTSTRAP_SWITCH) $(UNIT_TESTS)
else
	$(PHPUNIT_DIR)$(PHPUNIT_EXE) $(BOOTSTRAP_SWITCH) --group $(GROUP) $(UNIT_TESTS)
endif

########################################################################
# Rules (for Installing)
########################################################################

# make install
install: install-composer install-phpunit

# make install-composer
install-composer:
	curl -s $(COMPOSER_URL) | php
	php $(COMPOSER_PHAR) install

# make install-phpunit
install-phpunit:
	curl -L -o '$(PHPUNIT_PHAR)' '$(PHPUNIT_URL)'
	chmod +x $(PHPUNIT_PHAR)
	mv $(PHPUNIT_PHAR) $(PHPUNIT_EXE)
	./$(PHPUNIT_EXE) --version

########################################################################
# Rules (for Updating)
########################################################################

# make update
update: update-composer update-phpunit

# make update-composer
update-composer:
	php $(COMPOSER_PHAR) self-update

# make update-phpunit
update-phpunit: uninstall-phpunit install-phpunit

########################################################################
# Rules (for Uninstalling)
########################################################################

# make uninstall
uninstall: uninstall-composer uninstall-phpunit

# make uninstall-composer
uninstall-composer:
	rm -rf $(COMPOSER_DIR)
	rm -f $(COMPOSER_PHAR)

# make uninstall-phpunit
uninstall-phpunit:
	rm -f $(PHPUNIT_EXE)

########################################################################
# Rules (for Docker)
########################################################################

# make start-docker
start-docker:
	sudo service docker restart; sleep 10; docker --version

# make build-docker
build-docker:
	docker build -t $(DOCKER_GIT) .

# make run-docker
run-docker: build-docker clean-docker
	docker run -d -p 80:$(DOCKER_PORT) --name="$(DOCKER_APP)" \
	$(DOCKER_GIT) /bin/bash -c "php-fpm -D && nginx -g 'daemon off;'"

# make clean-docker
clean-docker:
	-docker stop $(DOCKER_APP)
	-docker rm -f $(DOCKER_APP)

# make clean
.PHONY: clean
clean: uninstall clean-docker
