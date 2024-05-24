# SOFTWAREHOUSE

## Overview

SOFTWAREHOUSE is a simulation of a software development company, built with Laravel and Vue 3. 

When a user registers, a game is automatically created for them with an initial budget of 5000. The application includes multiple cron schedules that run jobs to create and delete projects, developers, and salesforce based on certain conditions.

The navigation is divided into three sections:

1. **Productions**: This includes Projects and Developers.
2. **Sales**: This includes the salesforce.
3. **HR**: This includes the Salesforce and Developers, and serves as a way to hire developers or salesforce.

After hiring the salesforce, a job will eventually run and assign the salesforce to a project based on their complexity/experience. Once a developer is also assigned to the project, payments will be streamlined every 10 minutes in three phases: 30%, 40%, and the final 30%. After the final payment, the project will be considered completed and will be deleted in the next job deletion schedule.

## Docker Setup

Follow these steps to set up the application using Docker:

1. Add an entry to your hosts file (`/etc/hosts` on Linux or `system32/drivers/etc/hosts` on Windows) for `softwarehouse.test`, which is the domain name used in the `.env` file.
2. Run `composer install` to install all the required Laravel packages.
3. Start Docker.
4. Navigate to the project directory and run `./vendor/bin/sail up -d` to start the Docker containers in detached mode.
5. Run `./vendor/bin/sail npm i` to install all the npm dependencies.
6. Run `./vendor/bin/sail run dev` to start the application.
7. Open `softwarehouse.test/register` in your web browser to register and start using the application.
