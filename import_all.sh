#!/bin/bash
cons doctrine:database:drop --force
cons doctrine:database:create
cons doctrine:schema:update --force
cons doctrine:fixtures:load --no-interaction
