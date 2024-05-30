# SOFTWAREHOUSE

## Overview

SOFTWAREHOUSE is a simulation of a software development company, built with Laravel and Vue 3. 

Upon registration, each user is automatically initiated into a game with a starting budget of 5000. The application is designed with multiple cron schedules that execute tasks to dynamically create and remove projects, developers, and salesforce based on predefined conditions.

The navigation is divided into three sections:

1. **Productions**: This includes Projects and Developers.
2. **Sales**: This includes the salesforce.
3. **HR**: This includes the Salesforce and Developers, and serves as a way to hire developers or salesforce.

At the onset of the game, an intermediate project is automatically generated, along with a developer and a salesperson for the project. This initiates the game jobs to create the necessary projects and staff for recruitment. Post recruitment of the salesforce, a job is triggered to assign the salesforce to a project, taking into account their complexity/experience. Once a developer is assigned to the project, salary payments to the hired staff are processed every 30 seconds. Upon completion of the run_count, the project is marked as completed and the project's value is transferred to the game balance. Following the final payment, the project is deemed completed and is scheduled for deletion in the subsequent job deletion cycle. If the staff remains employed, the cost will accumulate and be deducted from the balance every 30 seconds.

## Docker Setup

Follow these steps to set up the application using Docker:

1. Add an entry to your hosts file (`/etc/hosts` on Linux or `system32/drivers/etc/hosts` on Windows) for `softwarehouse.test`, which is the domain name used in the `.env` file.
2. Run `composer install` to install all the required Laravel packages.
3. Start Docker.
4. Navigate to the project directory and run `./vendor/bin/sail up -d` to start the Docker containers in detached mode.
5. Run `./vendor/bin/sail npm i` to install all the npm dependencies.
6. Run `./vendor/bin/sail run dev` to start the application.
7. Open `softwarehouse.test/register` in your web browser to register and start using the application.
