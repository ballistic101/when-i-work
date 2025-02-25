# when-i-work
This is a homework assignment for the company When I Work.

The assigment was written in PHP because that is my fastest language to
develop in. If the time crunch were not there, I would probably have
tried this in Golang.

## Next Steps

These are the next steps that I would do with this project.

1. I would open the code in an IDE and check what its suggestions were for the code. I developed this project using vim only because I did not trust any IDEs to not use AI in some way (which was against the rules).
2. I would add phpstan and rector. By doing this I would be able to fix the code to those standards.
3. I would add more unit tests. There are more scenarios that could be tested, like if a shift lasts for days, or the daylight savings tests (which I think this could would pass in this state).
4. I would ask for more information about where this would need to live if it were to serve a larger purpose. That would dictate if this needs to be a web server using an API or in a library package or something.
5. I would attempt this again using a different programming language like Golang or JavaScript. It is interesting to understand if the design patterns associated with other languages can force algorithmic changes.

## How to Install

1. Check out this repository (https://github.com/ballistic101/when-i-work).
2. Copy the `dataset.json` file into the base directory of this repository.
3. Run `docker build -t when-i-work .`

## How to Run

1. `docker run -it --rm --name when-i-work-app when-i-work`
2. In another terminal, run `docker exec -it when-i-work-app /bin/bash -l`
3. Run `php assignment.php`.
4. In order to run the unit tests, run `./vendor/bin/phpunit tests`

When the docker container is run, it contains a long sleep command so that there is plenty of time to connect to the container from a different terminal.

