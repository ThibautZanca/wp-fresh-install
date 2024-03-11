# Wordpress template

This repository is for internal usage, It help you to create a new Wordpress project with the complete Adeliom stack.

## What is included

* Wordpess with a [Bedrock](https://github.com/roots/bedrock) architecture
* [Lumberjack](https://docs.lumberjack.rareloop.com/) theme
* A custom CLI helper for Lumberjack [See more](https://github.com/agence-adeliom/lumberjack-cli)
* Some providers for Lumberjack [See more](https://github.com/agence-adeliom/lumberjack-extensions)


## Installation

Use the [GitHub's template](https://github.com/agence-adeliom/wordpress-template/generate) to make your new repository.

Once your project is cloned run ;
```bash
$ make setup-env
```
This will help you to create your env variables with some questions.

## Usage

```bash
// This will scaffold averything you need to run the project 
$ make setup

// For more informations
$ make help
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)